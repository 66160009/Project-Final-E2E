# คำตอบ Bugs - สำหรับอาจารย์เท่านั้น

## 🔐 Security Vulnerabilities (10 bugs)

### BUG 1: Hard-coded Credentials (Critical)

**File:** config.php  
**Line:** 3-6  
**Type:** Security  
**Severity:** Critical

**ปัญหา:**

```php
$db_host = "db";
$db_user = "library_user";
$db_pass = "library_pass";
```

**วิธีแก้:**

- ใช้ environment variables
- ใช้ config file ที่ไม่ได้ commit ใน Git
- ใช้ secrets management

### BUG 2: No Error Handling in Database Connection (High)

**File:** config.php  
**Line:** 9  
**Type:** Security/Quality  
**Severity:** High

**วิธีทดสอบ:**

- ปิด database server
- ลอง connect

**วิธีแก้:**

```php
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
    error_log("Database connection failed");
    die("Service temporarily unavailable");
}
```

### BUG 3: No Character Set (Medium)

**File:** config.php  
**Line:** After connection  
**Type:** Data Integrity  
**Severity:** Medium

**ผลกระทบ:**

- ภาษาไทยอาจแสดงผิด
- Data corruption

**วิธีแก้:**

```php
mysqli_set_charset($conn, "utf8mb4");
```

### BUG 4: Debug Mode Always On (High)

**File:** config.php  
**Line:** 17  
**Type:** Security  
**Severity:** High

**ผลกระทบ:**

- เปิดเผยข้อมูลระบบ
- SQL queries แสดงใน HTML comments

**วิธีทดสอบ:**

- View page source
- ดู HTML comments

### BUG 5: SQL Injection in Login (Critical)

**File:** login.php  
**Line:** 10  
**Type:** Security  
**Severity:** Critical

**วิธีทดสอบ:**

```
Username: admin' OR '1'='1
Password: anything
```

**ผลลัพธ์:** Login สำเร็จโดยไม่ต้องรู้ password

**วิธีแก้:**

```php
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
// หรือใช้ prepared statements (แนะนำ)
```

### BUG 6-7: Login Logic Error (Critical)

**File:** login.php  
**Line:** 15-17  
**Type:** Security  
**Severity:** Critical

**ปัญหา:**

```php
if ($result) {  // ตรวจแค่ว่า query สำเร็จ ไม่ได้ตรวจว่ามี user
    $user = mysqli_fetch_assoc($result);
    // ไม่ตรวจสอบว่า $user เป็น null
```

**วิธีทดสอบ:**

- ใส่ username/password ที่ไม่มีในระบบ
- ระบบอาจ crash หรือ login ได้

**วิธีแก้:**

```php
if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    if ($user) {
        // set session
    }
}
```

### BUG 8: Weak Session Validation (Medium)

**File:** index.php, และทุกหน้า  
**Line:** 4-7  
**Type:** Security  
**Severity:** Medium

**ปัญหา:**

- ไม่ตรวจสอบ session timeout
- ไม่มี session regeneration

**วิธีแก้:**

```php
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// เพิ่ม timeout check
if (isset($_SESSION['LAST_ACTIVITY']) &&
    (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time();
```

### BUG 12: SQL Injection in Search (Critical)

**File:** books.php  
**Line:** 10-14  
**Type:** Security  
**Severity:** Critical

**วิธีทดสอบ:**

```
Search: ' OR 1=1--
หรือ: '; DROP TABLE books--
```

**วิธีแก้:**

```php
$search = mysqli_real_escape_string($conn, $_GET['search']);
```

### BUG 16: XSS Vulnerability (High)

**File:** books.php  
**Line:** JavaScript functions  
**Type:** Security  
**Severity:** High

**วิธีทดสอบ:**

- Add book with title: `<script>alert('XSS')</script>`
- หรือ: `<img src=x onerror=alert('XSS')>`

**วิธีแก้:**

```javascript
function viewBook(id) {
  id = parseInt(id); // validate
  window.location.href = "book_view.php?id=" + id;
}
```

### BUG 18: SQL Injection in Add Book (Critical)

**File:** book_add.php  
**Type:** Security

### BUG 34: SQL Injection in Add Member (Critical)

**File:** member_add.php  
**Type:** Security

### BUG 38: Incomplete Session Destruction (Medium)

**File:** logout.php  
**Line:** 4-7  
**Type:** Security  
**Severity:** Medium

**ปัญหา:**

```php
unset($_SESSION['user_id']); // แค่ unset แต่ไม่ destroy
```

**วิธีทดสอบ:**

- Logout แล้วกด Back
- อาจเข้าถึงหน้าเดิมได้

**วิธีแก้:**

```php
session_destroy();
session_unset();
```

---

## 🎯 Business Logic Errors (10 bugs)

### BUG 20: No Member Status Check (High)

**File:** borrow.php  
**Line:** 14-22  
**Type:** Business Logic  
**Severity:** High

**วิธีทดสอบ:**

1. Suspend member M001 ใน database:

```sql
UPDATE members SET status = 'suspended' WHERE member_code = 'M001';
```

2. ลองยืมหนังสือด้วย M001
3. **ผลลัพธ์:** ยืมได้แม้ถูก suspend

**วิธีแก้:**

```php
if ($member['status'] != 'active') {
    $error = "Member is not active!";
}
```

### BUG 21: Logic Error in Borrow Limit (Medium)

**File:** borrow.php  
**Line:** 28  
**Type:** Business Logic  
**Severity:** Medium

**ปัญหา:**

```php
if ($current_borrowed >= $member['max_books']) {
```

ควรเป็น `>` ไม่ใช่ `>=`

**วิธีทดสอบ:**

1. Students มี max_books = 3
2. ให้ยืม 2 เล่ม
3. ลองยืมเล่มที่ 3
4. **ผลลัพธ์:** ขึ้น error ว่าเกิน limit (แต่ควรยืมได้)

**Test Case:**

```
Given: Student M001 has max_books = 3
And: M001 has borrowed 2 books
When: M001 tries to borrow 1 more book
Then: Should allow (total = 3)
But: System shows error "reached maximum"
```

### BUG 23: Same Loan Period for All Members (Medium)

**File:** borrow.php  
**Line:** 40-41  
**Type:** Business Logic  
**Severity:** Medium

**ตาม Requirements:**

- Students: 14 days
- Teachers: 30 days
- Public: 7 days

**ปัจจุบัน:** ทุกคนได้ 14 days

**วิธีทดสอบ:**

```
1. ยืมด้วย teacher (M003)
2. Check due_date ใน database
3. ผลลัพธ์: +14 days (ควรเป็น +30)
```

**วิธีแก้:**

```php
$days = 14; // default
if ($member['member_type'] == 'teacher') {
    $days = 30;
} elseif ($member['member_type'] == 'public') {
    $days = 7;
}
$due_date = date('Y-m-d', strtotime("+$days days"));
```

### BUG 25: Incorrect Fine Calculation (High)

**File:** return.php  
**Line:** 25-28  
**Type:** Business Logic  
**Severity:** High

**ปัญหา:**

- การคำนวณอาจไม่แม่นยำ
- ใช้ timestamp แปลงเป็นวัน

**วิธีทดสอบ:**

```php
// Test case
Borrow: 2024-10-01
Due: 2024-10-15
Return: 2024-10-20
Expected fine: 5 days * 5 = 25 Baht
```

### BUG 26: Fixed Fine Rate (Medium)

**File:** return.php  
**Line:** 27  
**Type:** Business Logic  
**Severity:** Medium

**ปัญหา:** Fine rate ควรแตกต่างตามประเภทสมาชิก

- Students: 5 Baht/day
- Teachers: 10 Baht/day
- Public: 3 Baht/day

### BUG 27: No Maximum Fine Limit (Low)

**File:** return.php  
**Type:** Business Logic  
**Severity:** Low

**ปัญหา:** ถ้าเกิน 30 วัน fine อาจสูงเกินราคาหนังสือ

**วิธีแก้:**

```php
$fine = min($fine, 200); // จำกัดสูงสุด 200 บาท
```

### BUG 29: Documentation Mismatch (Low)

**File:** return.php  
**Line:** 162  
**Type:** Documentation  
**Severity:** Low

**ปัญหา:** Comment บอกว่า "calculated from day after due date" แต่จริงๆ คำนวณตั้งแต่วัน due date

### BUG 33: Wrong Max Books for Teacher (High)

**File:** member_add.php  
**Line:** 16-18  
**Type:** Business Logic  
**Severity:** High

**ปัญหา:**

```php
if ($member_type == 'teacher') {
    $max_books = 3; // ควรเป็น 5!
}
```

**วิธีทดสอบ:**

1. Add teacher member
2. Check max_books in database
3. **ผลลัพธ์:** max_books = 3 (ควรเป็น 5)

**Test Case:**

```
Given: Adding new teacher member
When: Save to database
Then: max_books should be 5
But: Actual result is 3
```

### BUG 35-37: Fine Display Mismatch (Medium)

**File:** reports.php  
**Line:** 68-96  
**Type:** Business Logic  
**Severity:** Medium

**ปัญหา:**

- Query ดึง fine_amount ที่บันทึกไว้
- แต่แสดง calculated fine แทน
- ทำให้ตัวเลขไม่ตรงกัน

---

## ✅ Data Validation Issues (11 bugs)

### BUG 13: No Available > Total Check (Medium)

**File:** books.php  
**Display section**  
**Type:** Data Validation  
**Severity:** Medium

**วิธีทดสอบ:**

1. แก้ database โดยตรง:

```sql
UPDATE books SET available_copies = 10 WHERE total_copies = 3 AND book_id = 1;
```

2. ดูหน้า books.php
3. **ผลลัพธ์:** แสดง available = 10, total = 3 (ไม่สมเหตุสมผล)

**วิธีแก้:**

- เพิ่ม CHECK constraint
- Validate ก่อน save

### BUG 14: No Future Year Validation (Low)

**File:** books.php  
**Line:** Modal form  
**Type:** Validation  
**Severity:** Low

**วิธีทดสอบ:**

```
Add book:
Title: Future Book
Publication Year: 2030
Result: ระบบรับ (ไม่ควรรับปีอนาคต)
```

**วิธีแก้:**

```html
<input
  type="number"
  name="publication_year"
  min="1900"
  max="<?php echo date('Y'); ?>"
/>
```

### BUG 15: Negative Values Allowed (High)

**File:** books.php  
**Type:** Validation  
**Severity:** High

**วิธีทดสอบ:**

```
Add book:
Total Copies: -5
Result: ระบบรับ
```

**Test Case:**

```
Boundary Value Analysis:
Valid: 0, 1, 100
Invalid: -1, -5, -100
```

**วิธีแก้:**

```html
<input type="number" name="total_copies" min="1" />
```

### BUG 17: No Duplicate ISBN Check (Medium)

**File:** book_add.php  
**Type:** Validation  
**Severity:** Medium

**วิธีทดสอบ:**

1. Add book with ISBN: 978-616-123-456-7
2. Add another book with same ISBN
3. **ผลลัพธ์:** Database error หรือ duplicate

**วิธีแก้:**

```php
$check = mysqli_query($conn, "SELECT * FROM books WHERE isbn = '$isbn'");
if (mysqli_num_rows($check) > 0) {
    $error = "ISBN already exists";
}
```

### BUG 19: No Error Handling (Medium)

**File:** book_add.php  
**Line:** 18  
**Type:** Error Handling  
**Severity:** Medium

**ปัญหา:**

```php
mysqli_query($conn, $sql); // ไม่เช็คว่าสำเร็จหรือไม่
```

**วิธีแก้:**

```php
if (!mysqli_query($conn, $sql)) {
    $error = "Failed to add book: " . mysqli_error($conn);
}
```

### BUG 30: No Auto-generate Member Code (Low)

**File:** members.php  
**Type:** Usability  
**Severity:** Low

**ปัญหา:** User ต้องใส่ member code เอง อาจซ้ำได้

**วิธีแก้:**

```php
// Generate: M001, M002, ...
$result = mysqli_query($conn,
    "SELECT MAX(CAST(SUBSTRING(member_code, 2) AS UNSIGNED)) as max_num
     FROM members");
$row = mysqli_fetch_assoc($result);
$next_num = ($row['max_num'] ?? 0) + 1;
$member_code = 'M' . str_pad($next_num, 3, '0', STR_PAD_LEFT);
```

### BUG 31: No Email Validation (Low)

**File:** members.php  
**Type:** Validation  
**Severity:** Low

**วิธีทดสอบ:**

```
Email: not-an-email
Result: ระบบรับ
```

**วิธีแก้:**

```html
<input type="email" name="email" />
```

หรือ

```php
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email format";
}
```

### BUG 32: No Duplicate Member Code Check (High)

**File:** member_add.php  
**Type:** Validation  
**Severity:** High

**คล้ายกับ BUG 17**

---

## 💾 Database & Performance Issues (7 bugs)

### BUG 9: Overdue Calculation Ignores Time (Medium)

**File:** index.php  
**Line:** 26-27  
**Type:** Logic  
**Severity:** Medium

**ปัญหา:**

```php
$sql = "... WHERE status = 'borrowed' AND due_date < CURDATE()";
```

ใช้ CURDATE() แทน NOW() อาจทำให้คำนวณผิดถ้าพิจารณาเวลา

### BUG 10: Status Not Auto-updated (High)

**File:** index.php และทุกหน้า  
**Type:** Data Integrity  
**Severity:** High

**ปัญหา:** status = 'overdue' ไม่อัพเดทอัตโนมัติ

**วิธีทดสอบ:**

1. Borrow book due yesterday
2. Check status ใน database
3. **ผลลัพธ์:** status = 'borrowed' (ควรเป็น 'overdue')

**วิธีแก้:**

- ใช้ TRIGGER
- ใช้ CRON job
- Update ทุกครั้งที่ query

```sql
CREATE TRIGGER update_overdue
BEFORE SELECT ON borrowing
FOR EACH ROW
BEGIN
    IF NEW.due_date < CURDATE() AND NEW.status = 'borrowed' THEN
        SET NEW.status = 'overdue';
    END IF;
END;
```

หรือ

```php
// Run before display
mysqli_query($conn,
    "UPDATE borrowing
     SET status = 'overdue'
     WHERE status = 'borrowed'
     AND due_date < CURDATE()");
```

### BUG 11: Inefficient Query (Low)

**File:** index.php  
**Line:** 70-73  
**Type:** Performance  
**Severity:** Low

**ปัญหา:**

```sql
SELECT ... FROM borrowing b, members m, books bk
WHERE b.member_id = m.member_id AND b.book_id = bk.book_id
```

ใช้ old-style JOIN

**วิธีแก้:**

```sql
SELECT ...
FROM borrowing b
INNER JOIN members m ON b.member_id = m.member_id
INNER JOIN books bk ON b.book_id = bk.book_id
```

### BUG 22: Race Condition (Critical)

**File:** borrow.php  
**Line:** 35-46  
**Type:** Concurrency  
**Severity:** Critical

**วิธีทดสอบ:**

1. เปิด 2 browser tabs
2. ยืมหนังสือเล่มสุดท้าย (available = 1) พร้อมกัน
3. **ผลลัพธ์:** ทั้ง 2 คนอาจยืมสำเร็จ แม้มีแค่ 1 เล่ม

**วิธีแก้:**

```sql
START TRANSACTION;
SELECT available_copies FROM books WHERE book_id = $book_id FOR UPDATE;
-- check availability
-- insert borrowing
-- update books
COMMIT;
```

### BUG 24: No Transaction (Critical)

**File:** borrow.php  
**Line:** 42-49  
**Type:** Data Integrity  
**Severity:** Critical

**ปัญหา:**

- INSERT borrowing
- UPDATE books
  ถ้า UPDATE fail borrowing ก็บันทึกแล้ว → ข้อมูลไม่สอดคล้อง

**วิธีทดสอบ:**

1. ทำให้ UPDATE fail (disconnect database ระหว่างทำ)
2. **ผลลัพธ์:** มี borrowing record แต่ available_copies ไม่ลด

**วิธีแก้:**

```php
mysqli_begin_transaction($conn);
try {
    // INSERT borrowing
    // UPDATE books
    mysqli_commit($conn);
} catch (Exception $e) {
    mysqli_rollback($conn);
}
```

### BUG 28: No Check on Return (Medium)

**File:** return.php  
**Line:** 39-42  
**Type:** Data Validation  
**Severity:** Medium

**ปัญหา:**

```php
UPDATE books SET available_copies = available_copies + 1
```

ไม่เช็คว่า available > total

**วิธีทดสอบ:**

1. แก้ available_copies = total_copies ใน database
2. คืนหนังสือ
3. **ผลลัพธ์:** available > total

**วิธีแก้:**

```php
$check = mysqli_query($conn,
    "SELECT available_copies, total_copies
     FROM books WHERE book_id = {$borrow['book_id']}");
$book = mysqli_fetch_assoc($check);
if ($book['available_copies'] < $book['total_copies']) {
    // update
}
```

---

## 📊 สรุป Test Cases ที่ควรทดสอบ

### Equivalence Partitioning

```
Member Types:
- Valid: student, teacher, public
- Invalid: admin, staff, ""

Max Books:
- Student: 0, 1, 2, 3, 4 (3 = valid, >3 = invalid)
- Teacher: 0-5 (valid), >5 (invalid)
```

### Boundary Value Analysis

```
Borrow Limit (Student, max=3):
- Valid: 0, 1, 2, 3
- Invalid: -1, 4

Publication Year:
- Valid: 1900, 2000, 2024
- Invalid: 1899, 2025

Fine Days:
- 0 days: fine = 0
- 1 day: fine = 5
- 30 days: fine = 150
```

### State Transition Testing

```
Book Status:
available → borrowed → returned → available
available → borrowed → overdue → returned

Member Status:
active → suspended → active
active → inactive
```

### Decision Table

```
Borrow Book Decision:
Conditions:
1. Member active?
2. Below max books?
3. Book available?

Actions:
Allow borrow / Deny

Truth table: 2^3 = 8 cases
```

---

## 🎯 Suggested Lab Exercises

### Lab 1: Find SQL Injection

- เวลา: 1 ชม.
- หา SQL Injection ทั้งหมด
- เขียน test cases
- Demo การ exploit

### Lab 2: Business Logic Testing

- เวลา: 2 ชม.
- ทดสอบ borrow/return
- หา logic errors
- เขียน bug reports

### Lab 3: Boundary Value Analysis

- เวลา: 1.5 ชม.
- ทดสอบ input validation
- หา boundary bugs
- สร้าง test data

### Lab 4: Integration Testing

- เวลา: 2 ชม.
- ทดสอบ borrow → return flow
- หา transaction bugs
- ทดสอบ concurrent access

---

**หมายเหตุ:** เอกสารนี้เป็นความลับ ห้ามแจกให้นิสิตก่อนจบการทดสอบ
