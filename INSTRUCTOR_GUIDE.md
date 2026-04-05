# สรุประบบ Library Management System

## 📦 สิ่งที่ได้รับ

### โครงสร้างโปรเจค

```
library-system/
├── docker-compose.yml          # Docker configuration
├── Dockerfile                  # PHP + mysqli setup
├── database/
│   └── init.sql               # Database schema + sample data
├── src/                       # PHP source code
│   ├── config.php             # Database config (4 bugs)
│   ├── login.php              # Login page (3 bugs)
│   ├── index.php              # Dashboard (3 bugs)
│   ├── books.php              # Books management (5 bugs)
│   ├── book_add.php           # Add book (3 bugs)
│   ├── borrow.php             # Borrow books (5 bugs)
│   ├── return.php             # Return books (5 bugs)
│   ├── members.php            # Members management (2 bugs)
│   ├── member_add.php         # Add member (3 bugs)
│   ├── reports.php            # Reports (3 bugs)
│   └── logout.php             # Logout (1 bug)
├── README.md                   # มีรายการ bugs
├── BUGS_ANSWER_KEY.md         # เฉลยละเอียด
├── QUICK_START.md             # สำหรับนิสิต
├── BUG_REPORT_TEMPLATE.md     # Template รายงาน bugs
├── .gitignore
└── .dockerignore
```

## 🐛 สรุป Bugs (38 ตัว)

### 1. Security Vulnerabilities (10 bugs)

- **BUG 1-4:** Config issues (credentials, encoding, debug)
- **BUG 5-7:** SQL Injection + Login logic errors
- **BUG 8:** Weak session validation
- **BUG 12:** SQL Injection in search
- **BUG 16:** XSS vulnerability
- **BUG 18:** SQL Injection in add book
- **BUG 34:** SQL Injection in add member
- **BUG 38:** Incomplete session destruction

### 2. Business Logic Errors (10 bugs)

- **BUG 20:** No member status check
- **BUG 21:** Borrow limit logic error (>= vs >)
- **BUG 23:** Same loan period for all
- **BUG 25-27:** Fine calculation errors
- **BUG 29:** Documentation mismatch
- **BUG 33:** Wrong max_books for teachers
- **BUG 35-37:** Fine display mismatch

### 3. Data Validation Issues (11 bugs)

- **BUG 13:** No available > total check
- **BUG 14:** No future year validation
- **BUG 15:** Negative values allowed
- **BUG 17:** No duplicate ISBN check
- **BUG 19:** No error handling
- **BUG 30:** No auto-generate member code
- **BUG 31:** No email validation
- **BUG 32:** No duplicate member code check

### 4. Database & Performance (7 bugs)

- **BUG 9:** Overdue calculation ignores time
- **BUG 10:** Status not auto-updated
- **BUG 11:** Inefficient query
- **BUG 22:** Race condition
- **BUG 24:** No transaction
- **BUG 28:** No check on return

## 🚀 วิธีเริ่มใช้งาน

### สำหรับนิสิต

1. แจก QUICK_START.md
2. ให้ติดตั้งและทดลองใช้

## 📝 Lab Exercises (แนะนำ)

### Lab 1: System Exploration (Week 1)

**เวลา:** 2 ชั่วโมง  
**วัตถุประสงค์:** ทำความรู้จักระบบ

**กิจกรรม:**

1. ติดตั้งระบบ (30 นาที)
2. ลองใช้ทุกฟีเจอร์ (45 นาที)
3. วิเคราะห์ requirements (45 นาที)

### Lab 2: Black Box Testing (Week 8)

**เวลา:** 2 ชั่วโมง

**กิจกรรม:**

1. Equivalence Partitioning exercise
2. Boundary Value Analysis exercise
3. Test borrow function

### Lab 3: Bug Hunting Competition (Week 13)

**เวลา:** 2 ชั่วโมง

**กิจกรรม:**

- แข่งกันหา bugs ให้ได้มากที่สุด
- คนที่หาได้มากที่สุดได้รางวัล
- ต้องเขียน bug report ที่ชัดเจน

### Lab 4: Bug Tracking System (Week 14)

**เวลา:** 2 ชั่วโมง

**กิจกรรม:**

1. Setup GitHub Issues
2. บันทึก bugs ที่พบ
3. Assign priority/severity
4. Practice bug triage

## 📚 เอกสารเพิ่มเติมที่ควรเตรียม

1. **SRS (Software Requirements Specification)**
   - Functional requirements
   - Non-functional requirements
   - Use cases

2. **Test Plan Template**
   - สำหรับนิสิตใช้เป็นแม่แบบ

3. **Grading Rubrics**
   - ละเอียดสำหรับแต่ละ assignment

4. **Sample Test Cases**
   - ให้ดูเป็นตัวอย่าง

5. **Bug Tracking Setup Guide**
   - วิธีใช้ GitHub Issues หรือ Jira

## 🎯 Expected Learning Outcomes

หลังเรียนจบนิสิตควรสามารถ:

1. ✅ เขียน test plan และ test strategy
2. ✅ ออกแบบ test cases ด้วย techniques ต่างๆ
3. ✅ Execute tests และ log results
4. ✅ หาและรายงาน bugs อย่างถูกต้อง
5. ✅ ใช้ bug tracking systems
6. ✅ วิเคราะห์ root cause
7. ✅ แนะนำวิธีแก้ไข
8. ✅ วัด software quality metrics

## ถ้ามีคำถามหรือต้องการความช่วยเหลือ:

- อัพเดทระบบ
- เพิ่ม features
- แก้ไข bugs
- เพิ่ม test cases
