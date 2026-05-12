<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About | Debre Markos University</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .about-box{
            background:#ffffff;
            padding:30px;
            border-radius:10px;
            box-shadow:0 4px 12px rgba(0,0,0,0.1);
            line-height:1.9;
            margin-bottom:30px;
        }
        .about-box h2{
            color:#2c3e50;
            margin-bottom:15px;
        }
        .about-box p{
            font-size:16px;
            color:#333;
            margin-bottom:12px;
        }
        .divider{
            height:2px;
            background:#ddd;
            margin:30px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <main class="main-card">

        <!-- ================= ENGLISH ================= -->
        <div class="about-box">
            <h2>About Debre Markos University</h2>

            <p>
                <strong>Debre Markos University (DMU)</strong> is a public higher education institution in Ethiopia,
                located in Debre Markos town of the Amhara Regional State. The university was established
                with the mission of delivering quality education, advancing research, and serving the community.
            </p>

            <p>
                The university offers a wide range of undergraduate and postgraduate programs in
                engineering, technology, natural sciences, social sciences, business, health sciences,
                and education. Debre Markos University is dedicated to producing competent,
                ethical, and innovative graduates.
            </p>

            <p>
                This <strong>Dormitory Management System</strong> is designed to manage student accommodation,
                room allocation, and dormitory resources efficiently. It helps administrators reduce errors,
                improve transparency, and provide better services to students.
            </p>

            <p>
                Debre Markos University continues to work towards academic excellence, innovation,
                and national development through education and research.
            </p>
        </div>

        <div class="divider"></div>

        <!-- ================= AMHARIC ================= -->
        <div class="about-box">
            <h2>ስለ ደብረ ማርቆስ ዩኒቨርሲቲ</h2>

            <p>
                <strong>ደብረ ማርቆስ ዩኒቨርሲቲ</strong> በኢትዮጵያ ውስጥ የሚገኝ የመንግስት ከፍተኛ ትምህርት ተቋም ሲሆን
                በአማራ ክልል ደብረ ማርቆስ ከተማ ውስጥ ይገኛል። ዩኒቨርሲቲው የተመሰረተው
                ጥራት ያለው ትምህርት ለመስጠት፣ ምርምርን ለማበረታታት እና ማህበረሰቡን ለማገልገል ነው።
            </p>

            <p>
                ዩኒቨርሲቲው በኢንጂነሪንግ፣ ቴክኖሎጂ፣ የተፈጥሮ ሳይንሶች፣ ማህበራዊ ሳይንሶች፣
                ንግድ፣ ጤና ሳይንስ እና ትምህርት መስኮች ውስጥ የተለያዩ የዲግሪ እና የማስተርስ ፕሮግራሞችን
                ይሰጣል። ባለሞያ፣ ታማኝ እና ተፈጥሯዊ ተመራቂዎችን ለማፍራት ትጋት ያደርጋል።
            </p>

            <p>
                ይህ <strong>የዶርሚተሪ አስተዳደር ሲስተም</strong> የተማሪዎችን መኖሪያ፣ የክፍል መመደብ
                እና የዶርሚተሪ ንብረቶችን በቀላሉ እና በትክክል ለማስተዳደር የተዘጋጀ ነው።
                ስርዓቱ የአስተዳዳሪዎችን ስራ ያቀላል እና ለተማሪዎች የተሻለ አገልግሎት ይሰጣል።
            </p>

            <p>
                ደብረ ማርቆስ ዩኒቨርሲቲ በትምህርት፣ በምርምር እና በማህበራዊ አገልግሎት
                ዘርፎች ውስጥ የሀገር እድገትን ለመደገፍ ቀጣይ ጥረት ያደርጋል።
            </p>
        </div>

    </main>
</div>

<p style="margin:18px 0 28px;text-align:center"><a href="dashboard.php" class="btn-link">Back to Dashboard</a></p>

</body>
</html>

