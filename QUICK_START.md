# Library Management System - Quick Start Guide

## 📖 เกี่ยวกับระบบ

ระบบจัดการห้องสมุดสำหรับการยืม-คืนหนังสือ

### ฟีเจอร์หลัก

- 📚 จัดการหนังสือ (เพิ่ม/ค้นหา)
- 👥 จัดการสมาชิก
- 📖 ยืม-คืนหนังสือ
- 💰 คำนวณค่าปรับ
- 📊 รายงานสถิติ

## 🚀 วิธีเริ่มใช้งาน

### 1. ติดตั้ง Docker

ตรวจสอบว่าติดตั้ง Docker แล้ว:

```bash
docker --version
docker-compose --version
```

### 2. เริ่มระบบ

```bash
# เข้าโฟลเดอร์โปรเจค
cd library-system

# เริ่มระบบ
docker-compose up -d

# ดู logs (ถ้าต้องการ)
docker-compose logs -f
```

### 3. เข้าใช้งาน

- **ระบบหลัก**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081

### 4. Login

```
Username: admin
Password: admin123
```

## 📋 ข้อมูลตัวอย่าง

### Members (สมาชิก)

| Code | Name               | Type    | Max Books |
| ---- | ------------------ | ------- | --------- |
| M001 | สมชาย ใจดี         | Student | 3         |
| M002 | สมหญิง รักหนังสือ  | Student | 3         |
| M003 | ดร.วิชัย อาจารย์   | Teacher | 5         |
| M004 | นางสาวมะลิ ทั่วไป  | Public  | 2         |
| M005 | นายทดสอบ บั๊กเกอร์ | Student | 3         |

### Books (หนังสือบางส่วน)

- การเขียนโปรแกรม Python
- โครงสร้างข้อมูล
- วิศวกรรมซอฟต์แวร์
- ฐานข้อมูล MySQL
- การทดสอบซอฟต์แวร์
- Harry Potter

## 📱 การใช้งานฟีเจอร์

### การยืมหนังสือ

1. ไปที่เมนู "Borrow"
2. ใส่ Member Code (เช่น M001)
3. เลือกหนังสือ
4. คลิก "Borrow Book"

### การคืนหนังสือ

1. ไปที่เมนู "Return"
2. ดูรายการหนังสือที่ยืมอยู่
3. คลิกปุ่ม "Return"
4. ระบบจะคำนวณค่าปรับอัตโนมัติ

### การค้นหาหนังสือ

1. ไปที่เมนู "Books"
2. ใช้ช่องค้นหา
3. ค้นหาด้วย Title, Author หรือ ISBN

## 🔧 กฎการยืม-คืน

### ระยะเวลาการยืม

- **นักเรียน/นิสิต**: 14 วัน, สูงสุด 3 เล่ม
- **อาจารย์**: 30 วัน, สูงสุด 5 เล่ม
- **บุคคลทั่วไป**: 7 วัน, สูงสุด 2 เล่ม

### ค่าปรับ

- **5 บาทต่อวัน** สำหรับหนังสือที่คืนเกินกำหนด
- เริ่มนับตั้งแต่วันแรกที่เกินกำหนด

## 🗃️ การเข้าถึง Database

### ผ่าน phpMyAdmin

1. เปิด http://localhost:8081
2. Server: `db`
3. Username: `root`
4. Password: `root_password`

### ผ่าน MySQL Client

```bash
docker exec -it library_db mysql -u root -p
# Password: root_password

USE library_db;
SHOW TABLES;
```

## 🛑 การหยุดและลบระบบ

### หยุดชั่วคราว

```bash
docker-compose stop
```

### เริ่มใหม่

```bash
docker-compose start
```

### ลบระบบและข้อมูล

```bash
docker-compose down -v
```

## 🐛 การแก้ปัญหา

### Port ซ้ำ

ถ้า port 8080 หรือ 8081 ถูกใช้แล้ว แก้ไขใน `docker-compose.yml`:

```yaml
ports:
  - "8082:80" # เปลี่ยนจาก 8080
```

### Database ไม่ทำงาน

```bash
# ลบและสร้างใหม่
docker-compose down -v
docker-compose up -d
```

### ภาษาไทยแสดงผิด

ตรวจสอบ character encoding ใน browser (ควรเป็น UTF-8)

## 📝 สำหรับการทดสอบ

### Test Accounts

```
Admin:
- Username: admin
- Password: admin123

Librarian:
- Username: librarian
- Password: lib123
```

### Test Scenarios

1. ลองยืมหนังสือด้วยสมาชิกต่างประเภท
2. ทดสอบการคืนช้าและดูค่าปรับ
3. ลองค้นหาหนังสือด้วยคำต่างๆ
4. ทดสอบยืมเกินจำนวนที่อนุญาต
5. ทดสอบเพิ่มหนังสือและสมาชิกใหม่

## 🎯 เป้าหมายการทดสอบ

ในการเรียนวิชา Software Testing:

1. หา bugs ในระบบ
2. เขียน test cases
3. ทดสอบตามแผน
4. เขียน bug reports
5. แนะนำการแก้ไข

ระบบนี้มี bugs ให้ค้นหา - จงหาให้เจอให้ครบ! 🔍

## 📚 เอกสารเพิ่มเติม

- คู่มือการเขียน Test Cases
- Template Bug Report
- Test Plan Template
