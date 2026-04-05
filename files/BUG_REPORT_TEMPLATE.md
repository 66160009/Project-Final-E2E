# Bug Report Template

## Bug Information

**Bug ID:** [เติมเมื่อบันทึกใน tracking system]  
**Title:** [สรุปสั้นๆ ของ bug]  
**Reported By:** [ชื่อผู้รายงาน]  
**Date Reported:** [วันที่พบ]  
**Module:** [ส่วนของระบบ เช่น Borrow, Return, Books]  

---

## Classification

**Severity:** [เลือก 1]
- [ ] Critical - ระบบใช้ไม่ได้/ข้อมูลเสียหาย
- [ ] High - ฟีเจอร์สำคัญใช้ไม่ได้
- [ ] Medium - ฟีเจอร์ใช้งานได้แต่มีปัญหา
- [ ] Low - ปัญหาเล็กน้อย/UI issues

**Priority:** [เลือก 1]
- [ ] P0 - แก้ทันที
- [ ] P1 - แก้ในวันนี้
- [ ] P2 - แก้ในสัปดาห์นี้
- [ ] P3 - แก้ในอนาคต

**Bug Type:** [เลือก 1 หรือมากกว่า]
- [ ] Security Vulnerability
- [ ] Business Logic Error
- [ ] Data Validation Issue
- [ ] Performance Issue
- [ ] UI/UX Issue
- [ ] Documentation Error

---

## Environment

**Browser:** [เช่น Chrome 120, Firefox 121]  
**OS:** [เช่น Windows 11, macOS 14, Ubuntu 22.04]  
**Database:** [MySQL 8.0]  
**URL:** [หน้าที่เกิดปัญหา]  
**User Role:** [Admin / Librarian]  

---

## Description

### Summary
[อธิบายปัญหาโดยสรุป 2-3 ประโยค]

### Detailed Description
[อธิบายรายละเอียดของปัญหา]

### Expected Behavior
[ระบบควรทำงานอย่างไร]

### Actual Behavior
[ระบบทำงานอย่างไรจริงๆ]

---

## Steps to Reproduce

1. [ขั้นตอนที่ 1]
2. [ขั้นตอนที่ 2]
3. [ขั้นตอนที่ 3]
...

### Preconditions
[สิ่งที่ต้องเตรียมก่อนทดสอบ เช่น ต้องมี member M001 ยืมหนังสือไว้ 2 เล่ม]

---

## Test Data

**Input Data:**
```
Field 1: [ค่าที่ใส่]
Field 2: [ค่าที่ใส่]
...
```

**Test Account:**
- Username: [username ที่ใช้ทดสอบ]
- Member Code: [ถ้ามี]

---

## Evidence

### Screenshots
[แนบ screenshot ที่แสดงปัญหา]

### Error Messages
```
[Copy error message ที่เห็น]
```

### Database State (ถ้ามี)
```sql
-- Query ที่ใช้ดูข้อมูล
SELECT * FROM borrowing WHERE borrow_id = 1;

-- ผลลัพธ์
[วาง result ที่ได้]
```

### Console Logs (ถ้ามี)
```
[F12 Console errors/warnings]
```

---

## Additional Information

### Frequency
- [ ] Always (100%)
- [ ] Often (>50%)
- [ ] Sometimes (25-50%)
- [ ] Rarely (<25%)

### Impact
[จำนวนผู้ใช้หรือฟีเจอร์ที่ได้รับผลกระทบ]

### Workaround
[วิธีแก้ชั่วคราว ถ้ามี]

---

## Related Issues

**Related To:**
- [ ] Bug #[number]
- [ ] Requirement #[number]
- [ ] Test Case #[number]

---

## Root Cause Analysis (สำหรับผู้แก้ไข)

### Root Cause
[สาเหตุที่แท้จริงของปัญหา]

### Affected Code
**File:** [ชื่อไฟล์]  
**Line:** [บรรทัดที่มีปัญหา]  
**Function:** [ชื่อ function]  

```php
// Code ที่มีปัญหา
[paste code snippet]
```

---

## Solution

### Proposed Fix
[วิธีแก้ไขที่เสนอ]

### Code Changes
```php
// Before
[code เดิม]

// After
[code ใหม่]
```

---

## Testing

### Verification Steps
1. [ขั้นตอนการ verify หลังแก้]
2. [...]

### Test Cases to Update
- [ ] Test Case #[number]
- [ ] Test Case #[number]

---

## Status

**Current Status:** [เลือก 1]
- [ ] New - เพิ่งพบ
- [ ] Confirmed - ยืนยันแล้วว่าเป็น bug
- [ ] In Progress - กำลังแก้ไข
- [ ] Fixed - แก้แล้ว
- [ ] Verified - ทดสอบแล้วหายแล้ว
- [ ] Closed - ปิดแล้ว
- [ ] Won't Fix - ไม่แก้
- [ ] Duplicate - ซ้ำกับ bug อื่น

**Assigned To:** [ผู้รับผิดชอบแก้]  
**Fixed By:** [ผู้แก้ไข]  
**Fixed Date:** [วันที่แก้]  
**Verified By:** [ผู้ตรวจสอบ]  
**Verified Date:** [วันที่ตรวจสอบ]  

---

## Comments

### [Date] - [Name]
[Comment]

---

## Example Bug Report

---

# Bug Report: SQL Injection in Login

## Bug Information

**Bug ID:** BUG-001  
**Title:** SQL Injection vulnerability in login page  
**Reported By:** Student Name  
**Date Reported:** 2024-10-30  
**Module:** Authentication (Login)  

---

## Classification

**Severity:** Critical  
**Priority:** P0  
**Bug Type:** Security Vulnerability  

---

## Environment

**Browser:** Chrome 120  
**OS:** Windows 11  
**Database:** MySQL 8.0  
**URL:** http://localhost:8080/login.php  
**User Role:** N/A (Login page)  

---

## Description

### Summary
Login page ไม่มีการ sanitize input ทำให้สามารถ SQL Injection ได้

### Expected Behavior
ระบบควรตรวจสอบและ escape special characters ใน username/password

### Actual Behavior
ระบบรับ input โดยตรงโดยไม่ตรวจสอบ ทำให้สามารถ bypass login ได้

---

## Steps to Reproduce

1. เปิดหน้า login http://localhost:8080/login.php
2. ใส่ username: `admin' OR '1'='1`
3. ใส่ password: `anything`
4. คลิก Login

### Expected Result
ควรแสดง error "Invalid username or password"

### Actual Result
Login สำเร็จและเข้าสู่ระบบได้

---

## Test Data

**Input Data:**
```
Username: admin' OR '1'='1
Password: anything
```

---

## Evidence

### SQL Query Generated
```sql
SELECT * FROM users WHERE username = 'admin' OR '1'='1' AND password = 'anything'
```
Query นี้จะเป็นจริงเสมอเพราะ '1'='1'

---

## Root Cause Analysis

### Root Cause
ไฟล์ login.php line 10 ใช้ string concatenation โดยตรงไม่มี input sanitization

### Affected Code
**File:** login.php  
**Line:** 10  

```php
// Vulnerable code
$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
```

---

## Solution

### Proposed Fix
ใช้ prepared statements หรือ mysqli_real_escape_string()

```php
// Solution 1: Prepared Statement (แนะนำ)
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ? AND password = ?");
mysqli_stmt_bind_param($stmt, "ss", $username, $password);
mysqli_stmt_execute($stmt);

// Solution 2: Escape String
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
```

---

## Status

**Current Status:** Confirmed  
**Assigned To:** Dev Team  

---
