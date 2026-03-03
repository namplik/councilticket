<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ระบบซื้อเหรียญ Ticket</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

<style>
body{
    background:#0f0f14;
    color:white;
    font-family:'Segoe UI',sans-serif;
}
/* Placeholder สีเทา เฉพาะ 2 ช่อง */
#amount::placeholder,
input[name="staff_name"]::placeholder {
    color: #9ca3af !important;
    opacity: 1;
}
.navbar{ background:#1a1a22; }
.navbar-brand{ color:#c084fc !important; font-weight:600; }
.form-wrapper{
    background:#1a1a22;
    padding:40px;
    border-radius:20px;
    box-shadow:0 0 25px rgba(111,66,193,0.2);
}
.form-control, .form-select{
    background:#111118 !important;
    color:white !important;
    border:1px solid #6f42c1 !important;
}
.form-control:focus, .form-select:focus{
    box-shadow:0 0 10px #6f42c1;
}
.btn-purple{ background:#6f42c1; color:white; }
.btn-purple:hover{ background:#5a32a3; }
.btn-back{ background:#2a2a35; color:white; }
.btn-back:hover{ background:#6f42c1; }

/* Select2 */
.select2-container--default .select2-selection--single{
    background:#111118 !important;
    border:1px solid #6f42c1 !important;
    height:38px;
}
.select2-selection__rendered{ color:white !important; }
.select2-dropdown{ background:#1a1a22 !important; color:white !important; }
.select2-results__option{ background:#1a1a22; color:white; }
.select2-results__option--highlighted{ background:#6f42c1 !important; }
</style>
</head>

<body>

<nav class="navbar px-4 py-3">
<span class="navbar-brand">💰 ระบบซื้อเหรียญ Ticket</span>
</nav>

<div class="container py-5">
<div class="form-wrapper">

<h3 class="text-center mb-4" style="color:#c084fc;">ซื้อเหรียญ Ticket</h3>

<form id="buyForm">

<div class="row g-3">

<!-- ประเภท -->
<div class="col-md-4">
<select name="category" id="category" class="form-select" required>
<option value="">-- เลือกประเภท --</option>
<option value="Gang">Gang</option>
<option value="Family">Family</option>
</select>
</div>

<!-- ชื่อ Gang/Family -->
<div class="col-md-4">
<select name="buyer" id="buyer" class="form-select" required>
<option value="">เลือกชื่อก่อน</option>
</select>
</div>

<!-- จำนวน -->
<div class="col-md-4">
<input type="number"
       name="amount"
       id="amount"
       class="form-control"
       placeholder="จำนวน Ticket (35,000 - 1,000,000)"
       min="35000"
       max="1000000"
       required>
</div>

<!-- 🔥 ชื่อผู้ทำรายการ (พิมพ์เอง) -->
<div class="col-md-6">
<input type="text"
       name="staff_name"
       class="form-control"
       placeholder="ชื่อผู้ทำรายการ"
       required>
</div>

<!-- 🔥 ชื่อสภาผู้รับผิดชอบ -->
<div class="col-md-6">
<select name="council_name" class="form-select" required>
<option value="">-- ชื่อสภาผู้รับผิดชอบ --</option>
<option>Davinchi Hydra</option>
<option>LungDang Over</option>
<option>Miaa Nakhrach</option>
<option>Peach Royalcharm</option>
<option>Minnie Joesz</option>
<option>Simba Way</option>
<option>BungThai RallTrade</option>
<option>Namplik Valencious</option>
<option>Lukmee Wannabemee</option>
<option>LeonS Meɾciless</option>
<option>New Glaywind</option>
<option>Som Jeed</option>
<option>Thaowan Calypso</option>
<option>Coolyock Freezeburn</option>
<option>Jab Mafuq</option>
<option>เพิ่มเติม</option>
</select>
</div>

</div>

<div class="mt-4">
<button type="submit" class="btn btn-purple w-100 py-2">
ยืนยันการซื้อ
</button>
</div>

</form>

<div id="result" class="mt-3"></div>

<hr class="my-4">

<div class="d-grid gap-3">
<a href="summary.php" class="btn btn-purple w-100">📊 สรุปยอดรวม</a>
<a href="main.php" class="btn btn-back w-100">🏠 กลับหน้า Main</a>
</div>

</div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

// =====================
// DATA LIST
// =====================

const gang = [/* เหมือนเดิมทั้งหมด */ 
"[2K] KEPKOT","[LZ] LAZY","[LLL] LERDLOEYLAH","[OR] ORION","[RF] ROYAL FLUSH",
"[RAK] RAKNADEKNGO","[HT] HAO TIAN","[7D] 7DAY","[TMD] TOMODACHI",
"[1ST] Firstclass","[HD] HADES","[BLB] Brooklynstyle","[JUD] JUDHAINOI",
"[GBGB] GoodboyGonebad","[BBS] Baby shark","[AKT] AKATI","[168] 168BOYS",
"[279] Twosevenninx","[BR] Badrak","[67] Sixseven","[P2N] Pornungai",
"[6MD] S!XMYDUCK","[Q] Question","[TSC] TOPSECRET","[H6] Homesix",
"[STARK] STARK","[VS] Vensence","[OB] ONE BEAT","[TGY] Targaryen",
"[AKR] AongKorn","[88E] 888","[RTS] RabamthepSuriyan","[DR] DOWRUNG",
"[TK] TICKET","[UDGX] UnderGroundx","[KLK] KUMLANGKISS","[VTR] VICTORIA",
"[7799] UZI","[DMR] Daimaru","[WN] WERNER","[TT] Thirtythree",
"[TF] THEFUCK","[MXM] Maximoff"
];

const family = [/* เหมือนเดิมทั้งหมด */
"[BAH] TAJABAAH","[FMN] FOR GET MENOT","[CBB] CANABIS BOY","[NP] NOPRO",
"[PK] POKO","[KS] KINSAEB","[EXN] EXTERNAL","[Xyla] Xyla","[VTR] Victoria",
"[MS] Maison","[FRW] Feral Warg","[CN] Chiznai","[HBUT] HEADBUTT",
"[GB] Gubyo","[RF] Real Fake","[BLD] Belinda","[LN] LUNA","[DKE] Darkenevil",
"[AG] AGENT","[KR] KIRIN","[P] Perng","[BS] BackSecret","[RDN] RODINA",
"[DK] Devil TheKid","[DT] DEKTAIKUB","[UD] Udon","[SKN] SIXKUNAS",
"[RVB] REVENBOY","[ES] Escape","[KTN] KRYPTONITE","[NX] Noyx","[VC] VELOCE",
"[111] TongAce","[BN] BANGNA","[SRS] SUMRANKS","[IRIS] IRIS","[HB] Hell Boy",
"[XBN] X Buuny","[UY] UP TO YOU","[AT] Arteei","[RM] RORMOR",
"[BN] BAANDON","[JET] JETRAY","[MMS] MIMOSA","[LH] LOHIT",
"[BB] Bunny Baddies","[LQ] Ledy Queen","[HMT] Hamiton","[WP] WAIPAO",
"[JP] JAIPHANG","[XAVI] Xavi","[PRX] Paper Rex","[NM] Nightmoon",
"[SCB] SUCCUBUS","[INU] AINUPAKZING","[INC] Innocent","[OVL] Overland",
"[HS] HAPPY SELL","[IM] IMMORTAL","[BD] BOUDOIR","[RNF] Realnofake",
"[WZ] Winzent","[VDL] Vandelinde","[ELT] ELITES","[789] 789style",
"[PKL] Phikadlup","[YB] YUBASHIRI","[HP] DEKHIGHPRO",
"[CONS] CONSIGLIERE","[RAK] PHOBRAK"
];

// =====================
// LOAD LIST
// =====================

function loadList(list){
    $("#buyer").empty().append('<option value=""></option>');
    list.forEach(name=>{
        $("#buyer").append(new Option(name, name));
    });
    $("#buyer").val(null).trigger("change");
}

$("#category").on("change", function(){
    if(this.value === "Gang"){ loadList(gang); }
    else if(this.value === "Family"){ loadList(family); }
    else{ $("#buyer").empty().append('<option value="">เลือกชื่อก่อน</option>'); }
});

$(document).ready(function() {
    $('#buyer').select2({
        placeholder: "พิมพ์เพื่อค้นหาชื่อ...",
        allowClear: true,
        width: '100%'
    });
});

$("#buyForm").submit(function(e){
    e.preventDefault();

    let amount = parseInt($("#amount").val());

    if(amount < 35000 || amount > 1000000){
        $("#result").html(`<div class="alert alert-danger">
        ❌ จำนวนต้องอยู่ระหว่าง 35,000 - 1,000,000
        </div>`);
        return;
    }

    $.post("fetch_summary.php",
        $(this).serialize() + "&type=buy",
        function(data){
            $("#result").html(data);
            $("#buyForm")[0].reset();
            $("#buyer").val(null).trigger("change");
        }
    );
});

</script>

</body>
</html>