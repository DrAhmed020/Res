<?php
// استقبال المدخلات
$year = $_POST['year'];
$month = $_POST['month'];
$name = $_POST['customerName'];
$file = $year . '/' . $month . '.csv';

// التحقق من الرقم الوظيفي
if (!preg_match('/^\d{9}$/', $name)) {
    echo '<h1>الرقم الوظيفي خطأ، يرجى التأكد من إدخال 9 أرقام باللغة الإنجليزية.</h1>';
    exit;
}

// التحقق من وجود الملف
if (!file_exists($file)) {
    echo '<h1>الملف المطلوب غير موجود! تأكد من اختيار السنة والشهر الصحيحين.</h1>';
    exit;
}

// فتح الملف والبحث عن الرقم الوظيفي
$output = "";
if (($handle = fopen($file, "r")) !== FALSE) {
    $found = false;
    echo '<table border="1" style="width: 100%; border-collapse: collapse; text-align: center; font-family: Arial;">';
    echo '<thead style="background-color: #f4f4f4; font-weight: bold;"><tr>';

    // قراءة الملف صفاً صفاً
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        if (!$found) {
            // التحقق من وجود الرقم الوظيفي داخل الصف
            if (in_array($name, $data)) {
                $output = $data;
                $found = true;
            }
        }

        // إنشاء رأس الجدول
        if (ftell($handle) == strlen($data[0])) {
            foreach ($data as $header) {
                echo '<th>' . htmlspecialchars($header) . '</th>';
            }
            echo '</tr></thead><tbody>';
        } elseif ($found) {
            // عرض الصف الذي يحتوي على الرقم الوظيفي
            echo '<tr>';
            foreach ($output as $cell) {
                echo '<td>' . htmlspecialchars($cell) . '</td>';
            }
            echo '</tr>';
            break;
        }
    }

    echo '</tbody></table>';
    fclose($handle);

    if (!$found) {
        echo '<h1>الرقم الوظيفي غير موجود في الملف.</h1>';
    }
} else {
    echo '<h1>حدث خطأ أثناء فتح الملف.</h1>';
}
?>
