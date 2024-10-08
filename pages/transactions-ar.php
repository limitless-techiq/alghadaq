<?php
if (!isset($_GET['s'])) {
  header('Location: https://alghadaqit.tech/');
}
include('../config/databaseconnect.php');
require_once('../vendor/autoload.php');
session_start();
if (!isset($_SESSION['token'])) {
  $_SESSION['token'] = md5(uniqid(mt_rand(), true));
}
$service = filter_var($_GET['s'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$d = date("Ymds", time());
$cart = $d . "-" . uniqid();
if (isset($_POST['submit'])) {
  //* Fields Data :
  $data = [
    "email" =>    filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
    "name" =>     filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
    "nickname" => filter_var($_POST['nickname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
    "phone" =>    filter_var($_POST['phone'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
    "country" =>  filter_var($_POST['country'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
    "city" =>     filter_var($_POST['city'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
    "address" =>  filter_var($_POST['address'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
    "desc" =>     filter_var($_POST['desc'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
    "amount" =>   filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_FLOAT),
    "currency" => filter_var($_POST['currency'], FILTER_SANITIZE_SPECIAL_CHARS),
  ];
  //* SQL / MYSQL QUERY :
  $stmt = $conn->prepare("INSERT INTO transactions (`email`,`name`,`nickname`,`phone`,`country`,`city`,`address`,`desc`,`amount`,`cart`,`currency`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $res = $stmt->execute([$data['email'], $data['name'], $data['nickname'], $data['phone'], $data['country'], $data['city'], $data['address'], $service . ": " . $data['desc'], $data['amount'], $cart, $data['currency']]);
  if ($res) {
    // * Telr Api :
    $client = new \GuzzleHttp\Client();
    $response = $client->request('POST', 'https://secure.telr.com/gateway/api_quicklink.json', [
      'body' => '{"quicklinkrequest":{"storeid":"29991","authkey":"5NVLN-8kK9^dVMWk","details":{"desc":"'  . $service . ": " . $data['desc'] . '","cart":"' . $cart . '","currency":"' . $data['currency'] . '","amount":"' . $data['amount'] . '","fullname":"' . $data['name'] . " " . $data['nickname'] . '","addr1":"' . $data['address'] . '","city":"' . $data['city'] . '","country":"' . $data['country'] . '","email":"' . $data['email'] . '","phone":"' . $data['phone'] . '"}}}',
      'headers' => [
        'accept' => 'application/json',
        'content-type' => 'application/json',
      ],
    ]);
    $body = json_decode($response->getBody());
    $status = $body->QuickLinkResponse->Status;
    if ($status == "Success") {
      //* SQL / MYSQL QUERY :
      $stmt = $conn->prepare("INSERT INTO transactions (`email`,`name`,`nickname`,`phone`,`country`,`city`,`address`,`desc`,`amount`,`cart`,`currency`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $_SESSION['url'] = $body->QuickLinkResponse->URL;
      $stmt = $conn->prepare('UPDATE transactions SET url=? WHERE cart=?');
      $stmt->execute([$_SESSION['url'], $cart]);
      header('Location: success.php');
    }
  }
  exit;
}
?>
<!DOCTYPE html>
<html lang="ar">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>ALGHADAQ - IT</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,600,600i,700,700i,900" rel="stylesheet">

  <!-- CSS Files -->
  <link href="../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
  <style>

  </style>
</head>

<body dir="rtl">
  <!-- ======= Top Bar ======= -->
  <section id="topbar" class="d-flex align-items-center">
    <div class="container d-flex justify-content-center justify-content-md-between">
      <div class="contact-info d-flex align-items-center" dir="ltr">
        <i class="bi bi-envelope-fill"></i><a href="mailto:contact@alghadaqit.tech">info@alghadaqit.tech</a>
        <i class="bi bi-phone-fill phone-icon"></i><a href="tel:+971581587300">+971 58 158 7300</a>
      </div>
      <div class="social-links d-none d-md-block">
        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
      </div>
    </div>
  </section>

    <!-- ======= Header ======= -->
  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex justify-content-between align-items-center">
      <div class="logo">
        <a href="#"><img src="../assets/img/logo.png" alt="" class="img-fluid"></a>
      </div>
      <nav id="navbar" class="navbar">
        <ul>
            <li class="m-2">
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-translate"></i>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="#">العربية</a></li>
                <li><a class="dropdown-item" href="transactions.php?s=<?php echo $_GET['s'] ?>">English</a></li>
              </ul>
            </div>
          </li>
          <li><a class="nav-link scrollto active" href="../index-ar.php#hero">الصفحة الرئيسية</a></li>
          <li><a class="nav-link scrollto" href="../index-ar.php#about">حولنا</a></li>
          <li><a class="nav-link scrollto" href="../index-ar.php#services">الخدمات</a></li>
          <li><a class="nav-link scrollto" href="../index-ar.php#team">أعضاء الفريق</a></li>
          <li><a class="nav-link scrollto" href="../index-ar.php#contact">الأتصال بنا</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>
      <!-- .navbar -->
    </div>
  </header>
  <!-- End Header -->
  <main id="main">
    <div class="container">
      <form method="POST" class="d-flex justify-content-center align-items-center flex-column my-3">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
        <!-- // ? Email -->
        <div class="input-group mb-3 position-relative">
          <span class="input-group-text" id="basic-addon1"><i class='bx bx-envelope'></i></span>
          <input type="email" name="email" class="form-control" placeholder="الأيميل" aria-label="email" aria-describedby="basic-addon1" required />
          <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
            <span class="visually-hidden">*</span>
          </span>
        </div>
        <!-- // ? Phone -->
        <div class="input-group mb-3 position-relative">
          <span class="input-group-text" id="basic-addon1"><i class='bx bx-phone'></i></span>
          <input type="text" name="phone" class="form-control" placeholder="الرقم" aria-label="phone" aria-describedby="basic-addon1" required />
          <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
            <span class="visually-hidden">*</span>
          </span>
        </div>
        <!-- // ? Name && Nickname -->
        <div class="w-100 d-flex justify-content-center align-items-center mb-3">
          <div class="input-group w-50 position-relative">
            <span class="input-group-text"><i class='bx bx-user-circle'></i></span>
            <input type="text" name="name" class="form-control" placeholder="الأسم الاول" aria-label="FirstName" required />
            <span class="position-absolute z-1 top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
              <span class="visually-hidden">*</span>
            </span>
          </div>
          <div class="input-group w-50 position-relative">
            <span class="input-group-text">@</span>
            <input type="text" name="nickname" class="form-control" placeholder="الأسم الثاني" aria-label="SecondName" required />
            <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
              <span class="visually-hidden">*</span>
            </span>
          </div>
        </div>
        <!-- // ? Country -->
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1"><i class='bx bxs-flag-alt'></i></span>
          <select name="country" class="form-select">
            <option value="af">Afghanistan</option>
            <option value="al">Albania</option>
            <option value="dz">Algeria</option>
            <option value="as">American Samoa</option>
            <option value="ad">Andorra</option>
            <option value="ao">Angola</option>
            <option value="ai">Anguilla</option>
            <option value="ag">Antigua and Barbuda</option>
            <option value="ar">Argentina</option>
            <option value="am">Armenia</option>
            <option value="aw">Aruba</option>
            <option value="au">Australia</option>
            <option value="at">Austria</option>
            <option value="az">Azerbaijan</option>
            <option value="bs">Bahamas</option>
            <option value="bh">Bahrain</option>
            <option value="bd">Bangladesh</option>
            <option value="bb">Barbados</option>
            <option value="by">Belarus</option>
            <option value="be">Belgium</option>
            <option value="bz">Belize</option>
            <option value="bj">Benin</option>
            <option value="bm">Bermuda</option>
            <option value="bt">Bhutan</option>
            <option value="bo">Bolivia</option>
            <option value="ba">Bosnia and Herzegovina</option>
            <option value="bw">Botswana</option>
            <option value="br">Brazil</option>
            <option value="io">British Indian Ocean Territory</option>
            <option value="vg">British Virgin Islands</option>
            <option value="bn">Brunei Darussalam</option>
            <option value="bg">Bulgaria</option>
            <option value="bf">Burkina Faso</option>
            <option value="bi">Burundi</option>
            <option value="kh">Cambodia</option>
            <option value="cm">Cameroon</option>
            <option value="ca">Canada</option>
            <option value="cv">Cape Verde</option>
            <option value="ky">Cayman Islands</option>
            <option value="cf">Central African Rep</option>
            <option value="td">Chad</option>
            <option value="cl">Chile</option>
            <option value="cn">China</option>
            <option value="cx">Christmas Island</option>
            <option value="cc">Cocos (Keeling) Islands</option>
            <option value="co">Colombia</option>
            <option value="km">Comoros</option>
            <option value="cd">Congo, Democratic Rep of</option>
            <option value="cg">Congo, Republic of</option>
            <option value="ck">Cook Islands</option>
            <option value="cr">Costa Rica</option>
            <option value="ci">Cote d'Ivoire</option>
            <option value="hr">Croatia</option>
            <option value="cy">Cyprus</option>
            <option value="cz">Czech Rep</option>
            <option value="dk">Denmark</option>
            <option value="dj">Djibouti</option>
            <option value="dm">Dominica</option>
            <option value="do">Dominican Rep</option>
            <option value="ec">Ecuador</option>
            <option value="eg">Egypt</option>
            <option value="sv">El Salvador</option>
            <option value="gq">Equatorial Guinea</option>
            <option value="er">Eritrea</option>
            <option value="ee">Estonia</option>
            <option value="et">Ethiopia</option>
            <option value="fk">Falkland Islands</option>
            <option value="fo">Faroe Islands</option>
            <option value="fj">Fiji</option>
            <option value="fi">Finland</option>
            <option value="fr">France</option>
            <option value="gf">French Guyana</option>
            <option value="pf">French Polynesia</option>
            <option value="ga">Gabon</option>
            <option value="gm">Gambia</option>
            <option value="ge">Georgia</option>
            <option value="de">Germany</option>
            <option value="gh">Ghana</option>
            <option value="gi">Gibraltar</option>
            <option value="gr">Greece</option>
            <option value="gl">Greenland</option>
            <option value="gd">Grenada</option>
            <option value="gp">Guadeloupe</option>
            <option value="gu">Guam</option>
            <option value="gt">Guatemala</option>
            <option value="gn">Guinea</option>
            <option value="gw">Guinea-Bissau</option>
            <option value="gy">Guyana</option>
            <option value="ht">Haiti</option>
            <option value="hn">Honduras</option>
            <option value="hk">Hong Kong</option>
            <option value="hu">Hungary</option>
            <option value="is">Iceland</option>
            <option value="in">India</option>
            <option value="id">Indonesia</option>
            <option value="iq">Iraq</option>
            <option value="ie">Ireland</option>
            <option value="il">Israel</option>
            <option value="it">Italy</option>
            <option value="jm">Jamaica</option>
            <option value="jp">Japan</option>
            <option value="jo">Jordan</option>
            <option value="kz">Kazakhstan</option>
            <option value="ke">Kenya</option>
            <option value="ki">Kiribati</option>
            <option value="kr">Korea, South</option>
            <option value="kw">Kuwait</option>
            <option value="kg">Kyrgyzstan</option>
            <option value="la">Laos</option>
            <option value="lv">Latvia</option>
            <option value="lb">Lebanon</option>
            <option value="ls">Lesotho</option>
            <option value="lr">Liberia</option>
            <option value="ly">Libya</option>
            <option value="li">Liechtenstein</option>
            <option value="lt">Lithuania</option>
            <option value="lu">Luxembourg</option>
            <option value="mo">Macau</option>
            <option value="mk">Macedonia</option>
            <option value="mg">Madagascar</option>
            <option value="mw">Malawi</option>
            <option value="my">Malaysia</option>
            <option value="mv">Maldives</option>
            <option value="ml">Mali</option>
            <option value="mt">Malta</option>
            <option value="mh">Marshall Islands</option>
            <option value="mq">Martinique</option>
            <option value="mr">Mauritania</option>
            <option value="mu">Mauritius</option>
            <option value="yt">Mayotte</option>
            <option value="mx">Mexico</option>
            <option value="fm">Micronesia</option>
            <option value="md">Moldova, Rep of</option>
            <option value="mc">Monaco</option>
            <option value="mn">Mongolia</option>
            <option value="me">Montenegro</option>
            <option value="ms">Montserrat</option>
            <option value="ma">Morocco</option>
            <option value="mz">Mozambique</option>
            <option value="mm">Myanmar</option>
            <option value="na">Namibia</option>
            <option value="nr">Nauru</option>
            <option value="np">Nepal</option>
            <option value="nl">Netherlands</option>
            <option value="an">Netherlands Antilles</option>
            <option value="nc">New Caledonia</option>
            <option value="nz">New Zealand</option>
            <option value="ni">Nicaragua</option>
            <option value="ne">Niger</option>
            <option value="ng">Nigeria</option>
            <option value="nu">Niue</option>
            <option value="nf">Norfolk Island</option>
            <option value="mp">Northern Mariana Islands</option>
            <option value="no">Norway</option>
            <option value="om">Oman</option>
            <option value="pk">Pakistan</option>
            <option value="pw">Palau</option>
            <option value="ps">Palestinian Territory, Occupied</option>
            <option value="pa">Panama</option>
            <option value="pg">Papua New Guinea</option>
            <option value="py">Paraguay</option>
            <option value="pe">Peru</option>
            <option value="ph">Philippines</option>
            <option value="pn">Pitcairn Islands</option>
            <option value="pl">Poland</option>
            <option value="pt">Portugal</option>
            <option value="pr">Puerto Rico</option>
            <option value="qa">Qatar</option>
            <option value="re">Reunion</option>
            <option value="ro">Romania</option>
            <option value="rw">Rwanda</option>
            <option value="ws">Samoa</option>
            <option value="sm">San Marino</option>
            <option value="st">Sao Tome and Principe</option>
            <option value="sa">Saudi Arabia</option>
            <option value="sn">Senegal</option>
            <option value="rs">Serbia</option>
            <option value="sc">Seychelles</option>
            <option value="sl">Sierra Leone</option>
            <option value="sg">Singapore</option>
            <option value="sk">Slovakia</option>
            <option value="si">Slovenia</option>
            <option value="sb">Solomon Islands</option>
            <option value="so">Somalia</option>
            <option value="za">South Africa</option>
            <option value="es">Spain</option>
            <option value="lk">Sri Lanka</option>
            <option value="sh">St Helena</option>
            <option value="kn">St Kitts and Nevis</option>
            <option value="lc">St Lucia</option>
            <option value="pm">St Pierre and Miquelon</option>
            <option value="vc">St Vincent and Grenadines</option>
            <option value="sr">Suriname</option>
            <option value="sz">Swaziland</option>
            <option value="se">Sweden</option>
            <option value="ch">Switzerland</option>
            <option value="tw">Taiwan, Rep of China</option>
            <option value="tj">Tajikistan</option>
            <option value="tz">Tanzania</option>
            <option value="th">Thailand</option>
            <option value="tl">Timor-Leste</option>
            <option value="tg">Togo</option>
            <option value="tk">Tokelau</option>
            <option value="to">Tonga</option>
            <option value="tt">Trinidad and Tobago</option>
            <option value="tn">Tunisia</option>
            <option value="tr">Turkey</option>
            <option value="tm">Turkmenistan</option>
            <option value="tc">Turks and Caicos Islands</option>
            <option value="tv">Tuvalu</option>
            <option value="ug">Uganda</option>
            <option value="ae" selected="">United Arab Emirates</option>
            <option value="gb">United Kingdom</option>
            <option value="vi">United States Virgin Islands</option>
            <option value="us">United States of America</option>
            <option value="uy">Uruguay</option>
            <option value="uz">Uzbekistan</option>
            <option value="vu">Vanuatu</option>
            <option value="va">Vatican City</option>
            <option value="ve">Venezuela</option>
            <option value="vn">Viet Nam</option>
            <option value="wf">Wallis and Futuna Islands</option>
            <option value="eh">Western Sahara</option>
            <option value="zm">Zambia</option>
            <option value="zw">Zimbabwe</option>
            <option value="ss">South Sudan</option>
          </select>
        </div>
        <!-- // ? City -->
        <div class="input-group mb-3 position-relative">
          <span class="input-group-text" id="basic-addon1"><i class='bx bx-building-house'></i></span>
          <input type="text" name="city" class="form-control" placeholder="المدينة" aria-label="city" aria-describedby="basic-addon1" required />
          <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
            <span class="visually-hidden">*</span>
          </span>
        </div>
        <!-- // ? Address -->
        <div class="input-group mb-3 position-relative">
          <span class="input-group-text" id="basic-addon1"><i class='bx bxs-edit-location'></i></span>
          <input type="text" name="address" class="form-control" placeholder="العنوان" aria-label="address" aria-describedby="basic-addon1" required />
          <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
            <span class="visually-hidden">*</span>
          </span>
        </div>
        <!-- // ? Currency -->
        <div class="input-group mb-3 position-relative">
          <span class="input-group-text" id="basic-addon1"><i class='bx bx-wallet'></i></span>
          <select name="currency" class="form-select">
            <option value="AED">UAE Dirhams</option>
          </select>
          <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
            <span class="visually-hidden">*</span>
          </span>
        </div>
        <!-- // ? Amount -->
        <div class="input-group mb-3 position-relative">
          <span class="input-group-text" id="basic-addon1"><i class='bx bx-credit-card-alt'></i></span>
          <input type="number" name="amount" class="form-control" placeholder="المبلغ" aria-label="amount" aria-describedby="basic-addon1" required />
          <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
            <span class="visually-hidden">*</span>
          </span>
        </div>
        <!-- // ? Description -->
        <div class="input-group mb-3 position-relative">
          <span class="input-group-text"><i class='bx bx-notepad'></i> الوصف </span>
          <textarea class="form-control" name="desc" aria-label="With textarea" required></textarea>
          <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
            <span class="visually-hidden">*</span>
          </span>
        </div>
        <button type="submit" name="submit" class="w-50 btn btn-success">أرسال</button>
      </form>
    </div>
  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-info">
            <h3>شركة الغدق لتكنولوجيا المعلومات</h3>
            <p>
              ملك أبو بكر أحمد عبيد بن طوق المري - ديرة نايف -
              <br>
              مكتب رقم A 5-406, الأمارات العربية المتحدة<br><br>
              <strong>Phone:</strong> +971 58 158 7300<br>
              <strong>Email:</strong> info@alghadaqit.tech<br>
            </p>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
              <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
              <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>روابط مفيدة</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#hero">الصفحة الرئيسية</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#about">حولنا</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#services">خدماتنا</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="pages/conditions.php">شروط الخدمة</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="pages/privacypolicy.php">سياسة الخصوصية</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Our Newsletter</h4>
            <form action="" method="post">
              <input type="email" name="email"><input type="submit" value="اشتراك">
            </form>

          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; حقوق النشر <strong><span>شركة الغدق لتكنولوجيا المعلومات</span></strong>. كل الحقوق محفوظة
        <br />
        <a href="pages/privacypolicy.php" target="_blank" rel="noopener noreferrer">سياسة الخصوصية</a>
        <span>-</span>
        <a href="pages/conditions.php" target="_blank" rel="noopener noreferrer">الشروط & الاحكام</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- JS Files -->
  <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>