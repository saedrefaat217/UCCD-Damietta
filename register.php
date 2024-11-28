<?php
// الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uccd_damietta";  // تأكد من أن اسم قاعدة البيانات صحيح

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// استلام البيانات من النموذج
$name = $_POST['name'];
$phone = $_POST['phone'];
$national_id = $_POST['national_id'];
$email = $_POST['email'];
$graduation_year = $_POST['graduation_year'];
$gender = $_POST['gender'];
$birth_date = $_POST['birth_date'];
$course = $_POST['course'];

// تحميل الصور
$front_id_image = $_FILES['front_id']['name'];
$back_id_image = $_FILES['back_id']['name'];
$card_image = $_FILES['card_image']['name'];

// مسار تخزين الصور
$target_dir = "uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir);
}

$front_id_path = $target_dir . basename($front_id_image);
$back_id_path = $target_dir . basename($back_id_image);
$card_path = $target_dir . basename($card_image);

// نقل الصور إلى مجلد التخزين
move_uploaded_file($_FILES['front_id']['tmp_name'], $front_id_path);
move_uploaded_file($_FILES['back_id']['tmp_name'], $back_id_path);
move_uploaded_file($_FILES['card_image']['tmp_name'], $card_path);

// إدخال البيانات إلى قاعدة البيانات
$sql = "INSERT INTO students (name, phone, national_id, email, graduation_year, gender, birth_date, course, front_id_image, back_id_image, card_image)
VALUES ('$name', '$phone', '$national_id', '$email', '$graduation_year', '$gender', '$birth_date', '$course', '$front_id_path', '$back_id_path', '$card_path')";

if ($conn->query($sql) === TRUE) {
    echo "تم التسجيل بنجاح!";
} else {
    echo "خطأ: " . $sql . "<br>" . $conn->error;
}

// إغلاق الاتصال
$conn->close();
?>
