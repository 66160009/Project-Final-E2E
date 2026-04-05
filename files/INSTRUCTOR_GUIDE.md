# สรุประบบ Library Management System

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

## 🎯 จุดประสงค์การสอน

### สัปดาห์ที่ 1-2: Software Quality

- **แนะนำระบบ:** ให้นิสิตลองใช้ทุกฟีเจอร์
- **กำหนดการบ้าน:** วิเคราะห์ quality attributes

### สัปดาห์ที่ 3-4: Test Planning

- **Lab:** เขียน Test Plan ให้กับระบบนี้
- **Workshop:** Review Test Plans ร่วมกัน

### สัปดาห์ที่ 5-6: V&V, Reviews

- **Lab:** Code Review (ให้ source code)
- **Exercise:** Inspection checklist

### สัปดาห์ที่ 7-9: Testing Techniques

- **Black Box:**
  - Equivalence Partitioning (member types, max books)
  - Boundary Value Analysis (0, 1, max, max+1)
  - Decision Tables (borrow conditions)
- **White Box:**
  - Path Testing (borrow.php, return.php)
  - Statement/Branch Coverage

### สัปดาห์ที่ 10-11: Test Case Design

- **Lab:** เขียน test cases สำหรับทุก module
- **ตัวอย่าง:** ให้ test cases ตัวอย่างบางส่วน

### สัปดาห์ที่ 12-13: Test Execution

- **Lab:** Execute tests และ log results
- **Bug Hunting:** ให้แข่งกันหา bugs

### สัปดาห์ที่ 14-15: Bug Tracking

- **Setup:** GitHub Issues
- **Exercise:** เขียน bug reports ที่ดี

## 📊 แนะนำการประเมินผล

### Assignment 1: Test Plan (15%)

**ให้ทำ:** สัปดาห์ที่ 4  
**ส่ง:** สัปดาห์ที่ 5

**เกณฑ์การให้คะแนน:**

- Test Strategy (30%)
- Test Scope & Coverage (25%)
- Test Schedule (20%)
- Resource Planning (15%)
- Risk Analysis (10%)

### Assignment 2: Test Cases (20%)

**ให้ทำ:** สัปดาห์ที่ 10  
**ส่ง:** สัปดาห์ที่ 11

**เกณฑ์การให้คะแนน:**

- Coverage (30%) - ครอบคลุมทุก requirements
- Techniques (25%) - ใช้ testing techniques หลากหลาย
- Quality (25%) - Test cases เขียนดี clear, reproducible
- Test Data (20%) - Test data เหมาะสม

**ข้อกำหนด:**

- อย่างน้อย 50 test cases
- ครอบคลุมทุก module
- ใช้อย่างน้อย 3 testing techniques

### Assignment 3: Bug Reports (20%)

**ให้ทำ:** สัปดาห์ที่ 13  
**ส่ง:** สัปดาห์ที่ 14

**เกณฑ์การให้คะแนน:**

- จำนวน bugs ที่พบ (30%)
  - 10-15 bugs: 15 คะแนน
  - 16-25 bugs: 22 คะแนน
  - 26-35 bugs: 28 คะแนน
  - 36-38 bugs: 30 คะแนน (เต็ม)
- คุณภาพ bug reports (40%)
  - Reproducibility
  - Severity/Priority classification
  - Evidence (screenshots, logs)
- Organization (30%)
  - Use bug tracking system
  - Proper formatting

### Final Project: Complete Testing Report (30%)

**ส่ง:** สัปดาห์สุดท้าย

**ต้องมี:**

1. Executive Summary (5%)
2. Test Plan (5%)
3. Test Cases (จาก Assignment 2) (5%)
4. Test Execution Results (5%)
5. Bug Reports (จาก Assignment 3) (5%)
6. Quality Metrics Analysis (5%)
   - Coverage metrics
   - Defect density
   - Test effectiveness

### Participation & Lab (15%)

- การทำ lab exercises
- การมีส่วนร่วมในชั้นเรียน
- Code review participation

## 🚀 วิธีเริ่มใช้งาน

### สำหรับนิสิต

1. แจก QUICK_START.md
2. ให้ติดตั้งและทดลองใช้
3. **อย่าแจก README.md และ BUGS_ANSWER_KEY.md**

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

## 📞 Contact & Support

ถ้ามีคำถามหรือต้องการความช่วยเหลือ:

- อัพเดทระบบ
- เพิ่ม features
- แก้ไข bugs
- เพิ่ม test cases

## 📈 Version History

**Version 1.0** (Current)

- 38 bugs across 4 categories
- 12 PHP files
- MySQL database
- Docker setup
- Complete documentation
