# Complaints — نظام الشكاوى (السجل المدني)

نظام PHP + MySQL لتقديم الشكاوى والمقترحات ومتابعتها برقم المتابعة، مع لوحة إدارة وإرسال SMS عبر Twilio.

## المتطلبات
- PHP 8.x + MySQL/MariaDB (XAMPP)
- Composer

## التشغيل
1. انسخ المشروع إلى `htdocs/complaints`
2. أنشئ قاعدة بيانات `complaints` واستورد ملف `complaints.sql` (هيكل الجداول فقط، بدون بيانات):
   - phpMyAdmin ← استيراد ← `complaints.sql`
3. أنشئ حساب إدارة تجريبي:
   ```sql
   INSERT INTO `admin` (`userName`, `Password`) VALUES ('admin', SHA1('admin123'));
   ```
   ثم ادخل للوحة الإدارة بـ `admin / admin123`
4. إعداد الاتصال في `conect.php` (الوضع الافتراضي: `localhost / complaints / root / بدون كلمة سر`)
5. تثبيت المكتبات:
   ```bash
   composer install
   ```
   (المجلد `vendor/` مستبعد من Git قصداً — يُبنى بهذا الأمر)
6. افتح: `http://localhost/complaints/index.php`

## إرسال SMS (Twilio) — اختياري
صفحة `admin/send_sms.php` فقط تحتاج Twilio. لا توجد مفاتيح داخل الكود — اضبط متغيرات البيئة:
```bash
TWILIO_SID=ACxxxxxxxxxxxxxxxx
TWILIO_TOKEN=xxxxxxxx
TWILIO_NUMBER=+249000000000
```
بدونها يعمل الموقع كاملاً ما عدا إرسال الرسائل.

## ملاحظة
لا ترفع `vendor/` إلى Git — يُعاد توليده بـ `composer install`.
