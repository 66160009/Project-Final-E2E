<<<<<<< HEAD
# Library Management System - Educational Version

ระบบจัดการห้องสมุดแบบง่ายๆ สำหรับการเรียนการสอนวิชา Software Testing and Evaluation

## 🎯 วัตถุประสงค์

ระบบนี้ออกแบบมาเพื่อใช้ในการเรียนการสอน โดยมี **bugs ที่ฝังไว้อย่างตั้งใจ** เพื่อให้ผู้เรียนฝึกฝน:

- การหา bugs ด้วยเทคนิคต่างๆ
- การเขียน test cases
- การทดสอบซอฟต์แวร์
- การเขียน bug reports
- การใช้ bug tracking systems

## 🚀 การติดตั้ง

### ข้อกำหนดเบื้องต้น

- Docker
- Docker Compose

### วิธีติดตั้ง

1. Clone หรือ download โปรเจค

2. เปิด Terminal/Command Prompt ที่โฟลเดอร์โปรเจค

3. รันคำสั่ง:

```bash
docker-compose up -d
```

4. รอให้ Docker สร้าง containers (ครั้งแรกอาจใช้เวลาสักครู่)

5. เข้าใช้งานผ่าน browser:
   - **ระบบหลัก**: http://localhost:8080
   - **phpMyAdmin**: http://localhost:8081

### ข้อมูล Login

**ผู้ใช้งาน:**

- Username: `admin` / Password: `admin123` (Admin)
- Username: `librarian` / Password: `lib123` (Librarian)

**phpMyAdmin:**

- Server: `db`
- Username: `root`
- Password: `root_password`

## 📚 ฟังก์ชันหลัก

1. **Dashboard** - แสดงภาพรวมระบบ
2. **Books Management** - จัดการหนังสือ (เพิ่ม/แก้ไข/ค้นหา)
3. **Members Management** - จัดการสมาชิก
4. **Borrow Books** - ยืมหนังสือ
5. **Return Books** - คืนหนังสือและคำนวณค่าปรับ
6. **Reports** - รายงานต่างๆ

## 🐛 รายการ Bugs ที่ฝังไว้

### กลุ่ม Security Vulnerabilities (ความปลอดภัย)

**BUG 1-4:** การจัดการ Configuration ไม่ปลอดภัย (config.php)

- Hard-coded credentials
- ไม่มี error handling
- ไม่ set character encoding
- Debug mode เปิดตลอด

**BUG 5-7:** SQL Injection & Authentication Issues (login.php)

- SQL Injection ในหน้า login
- Logic error ในการตรวจสอบผลลัพธ์
- ไม่ตรวจสอบว่ามี user จริง

**BUG 8:** Session Management (index.php)

- ไม่ตรวจสอบ session timeout

**BUG 12:** SQL Injection ในการค้นหา (books.php)

- Search query ไม่มีการ sanitize

**BUG 16:** XSS Vulnerability (books.php)

- JavaScript ไม่มีการ sanitize input

**BUG 18:** SQL Injection ในการเพิ่มหนังสือ (book_add.php)

**BUG 34:** SQL Injection ในการเพิ่มสมาชิก (member_add.php)

**BUG 38:** Session Destruction ไม่สมบูรณ์ (logout.php)

### กลุ่ม Business Logic Errors (ตรรกะทางธุรกิจ)

**BUG 20:** ไม่ตรวจสอบสถานะสมาชิก (borrow.php)

- สมาชิก suspended/inactive ยังยืมได้

**BUG 21:** Logic Error ในการตรวจสอบ (borrow.php)

- ใช้ `>=` แทน `>` ทำให้นับผิด

**BUG 23:** Loan Period ไม่แตกต่างตามประเภทสมาชิก (borrow.php)

- ทุกคนได้ 14 วัน แทนที่จะแยกตามประเภท

**BUG 25-27:** การคำนวณค่าปรับผิดพลาด (return.php)

- วิธีคำนวณไม่ถูกต้อง
- Fine rate ไม่แตกต่างตามประเภทสมาชิก
- ไม่มีการจำกัดค่าปรับสูงสุด

**BUG 29:** Documentation ไม่ตรงกับ Implementation (return.php)

**BUG 33:** Logic Error ในการกำหนด max_books (member_add.php)

- Teachers ได้แค่ 3 เล่ม แทนที่จะเป็น 5

**BUG 35-37:** การคำนวณ Fine ในรายงาน (reports.php)

- ค่าที่แสดงไม่ตรงกับที่บันทึก

### กลุ่ม Data Validation Issues (การตรวจสอบข้อมูล)

**BUG 13:** ไม่ตรวจสอบ available > total (books.php)

**BUG 14:** ไม่ตรวจสอบปีที่เป็นอนาคต (books.php)

**BUG 15:** ไม่ตรวจสอบค่าติดลบ (books.php)

- จำนวนหนังสือสามารถเป็นค่าลบได้

**BUG 17:** ไม่ตรวจสอบ ISBN ซ้ำ (book_add.php)

**BUG 19:** ไม่มี Error Handling (book_add.php)

**BUG 30:** ไม่มีการ Auto-generate Member Code (members.php)

**BUG 31:** ไม่ตรวจสอบรูปแบบ Email (members.php)

**BUG 32:** ไม่ตรวจสอบ Member Code ซ้ำ (member_add.php)

### กลุ่ม Database & Performance Issues

**BUG 9:** Overdue Calculation ไม่พิจารณาเวลา (index.php)

**BUG 10:** Overdue Status ไม่อัพเดทอัตโนมัติ (index.php)

**BUG 11:** Query ไม่มีประสิทธิภาพ (index.php)

- ใช้ old-style JOIN แทน INNER JOIN

**BUG 22:** Race Condition (borrow.php)

- ไม่มีการ lock record

**BUG 24:** ไม่มี Transaction (borrow.php)

- อาจทำให้ข้อมูลไม่สอดคล้องกัน

**BUG 28:** ไม่ตรวจสอบ available > total เมื่อคืน (return.php)

## 📋 แนวทางการใช้งานสำหรับการสอน

### สัปดาห์ที่ 1-2: Software Quality

- ให้ผู้เรียนทดลองใช้ระบบ
- วิเคราะห์ quality attributes
- ระบุ quality metrics ที่ใช้วัด

### สัปดาห์ที่ 3-4: Test Planning

- เขียน Test Plan
- กำหนด Test Strategy
- วางแผนการทดสอบแต่ละ module

### สัปดาห์ที่ 5-6: Reviews & Inspections

- Review code (ดูไฟล์ .php)
- ใช้ checklist หา bugs
- ฝึกทำ peer review

### สัปดาห์ที่ 7-9: Testing Techniques

- **Black Box Testing:**
  - ทดสอบการยืม/คืนหนังสือ
  - ทดสอบการคำนวณค่าปรับ
  - ทดสอบ search function
- **White Box Testing:**
  - วิเคราะห์ code coverage
  - ทดสอบทุก branch
  - ทดสอบ boundary conditions

### สัปดาห์ที่ 10-11: Test Case Design

- เขียน test cases สำหรับทุกฟังก์ชัน
- ออกแบบ test data
- ทำ traceability matrix

### สัปดาห์ที่ 12-13: Execute Tests

- Run test cases
- Record ผลการทดสอบ
- เขียน bug reports

### สัปดาห์ที่ 14-15: Bug Tracking & Reporting

- ใช้ GitHub Issues หรือ bug tracking tool
- เขียน bug reports ที่ดี
- Prioritize bugs
- Follow up การแก้ไข

## 🎓 การประเมินผล (ตัวอย่าง)

### Assignment 1: Test Plan (15%)

- ความครบถ้วนของ test plan
- Test strategy ที่เหมาะสม
- Resource planning

### Assignment 2: Test Cases Design (20%)

- ครอบคลุมทุก requirements
- ใช้ testing techniques หลากหลาย
- Test data ที่เหมาะสม

### Assignment 3: Bug Reports (20%)

- พบ bugs กี่ตัว (จาก 38 ตัว)
- คุณภาพของ bug reports
- Severity/Priority classification

### Final Project: Complete Testing Report (30%)

- Test execution results
- Coverage analysis
- Quality metrics
- Recommendations

### Participation & Lab (15%)

- การทำ lab exercises
- การมีส่วนร่วมในชั้นเรียน

## 🔧 Troubleshooting

### ถ้า Docker ไม่ทำงาน

```bash
# หยุด containers
docker-compose down

# ลบ volumes (ระวัง: ข้อมูลจะหาย)
docker-compose down -v

# สร้างใหม่
docker-compose up -d
```

### ถ้าเข้า phpMyAdmin ไม่ได้

ลอง login ด้วย:

- Username: `library_user`
- Password: `library_pass`
- Database: `library_db`

### ถ้า Port ซ้ำ

แก้ไขในไฟล์ `docker-compose.yml`:

```yaml
ports:
  - "8082:80" # แทน 8080:80
```

## 📊 สถิติ Bugs

- **Total Bugs:** 38 ตัว
- **Security:** 10 ตัว (26%)
- **Business Logic:** 10 ตัว (26%)
- **Validation:** 11 ตัว (29%)
- **Database/Performance:** 7 ตัว (18%)

## 📚 เอกสารเพิ่มเติม

- SRS (Software Requirements Specification) - ควรสร้างแยก
- Test Plan Template - ควรมีให้ผู้เรียน
- Bug Report Template - ใช้ใน GitHub Issues
- Grading Rubrics - กำหนดเกณฑ์การให้คะแนน

## 🤝 การมีส่วนร่วม

ถ้าพบ bugs เพิ่มเติมหรือต้องการปรับปรุงระบบ สามารถแก้ไขได้เลย

## 📄 License

ระบบนี้สร้างขึ้นเพื่อการศึกษาเท่านั้น ไม่เหมาะสำหรับใช้งานจริง

---
