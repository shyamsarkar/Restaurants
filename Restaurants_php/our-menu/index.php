<?php
include("action.php");
?>
<!DOCTYPE html>
<html>
<title>The Cafe Dakar</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">

<style type="text/css">
  .rupee {
    font-size: 20px;
    font-weight: bold;
    padding-top: 5px;
    padding-right: 5px;
  }

  .scrollmenu {
    background-color: #4caf50;
    overflow: auto;
    white-space: nowrap;
  }

  .scrollmenu a {
    display: inline-block;
    color: white;
    text-align: center;
    padding: 10px;
    text-decoration: none;
  }

  .scrollmenu a:hover {
    background-color: #777;
  }

  .w3-button:hover {
    color: #fff !important;
    background-color: #f44336 !important;
  }

  .w3-gyellow {
    background: #EB3349;
    background: -webkit-linear-gradient(to right, #F45C43, #EB3349);
    background: linear-gradient(to right, #F45C43, #EB3349);
    color: white;
  }

  h1 {
    font-family: 'Dancing Script', cursive;
  }

  h6 {
    font-family: Arial, sans-serif;
    font-weight: 600;
  }

  p {
    overflow: hidden;
    color: #534841;
    padding-left: 5px;
  }
</style>

<body class="">

  <div class="w3-container">
    <div class="w3-row">
      <div class="w3-col s12">
        <center>
          <img src="indianchilly_logo.png" class="w3-margin-bottom w3-margin-top" style="width:auto;height:auto;max-height:112px;">
        </center>
      </div>
    </div>

    <!-- <h1>Our Menu</h1> -->

    <div class="scrollmenu">
      <a class="w3-button w3-round tablink w3-red" onclick="refreash();">All</a>
      <?php
      $crow = $obj->executequery("select * from m_product_category where checked_status='1' order by catname asc");
      foreach ($crow as $cres) {

      ?>
        <a class="w3-button w3-round tablink w3-border-right" onclick="openCity(event,'<?php echo $cres['pcatid']; ?>')"><?php echo strtoupper($cres['catname']); ?></a>
      <?php } ?>
      <!--  <a class="w3-button tablink" onclick="openCity(event,'Tokyo')">Tokyo</a> -->
    </div>
    <div style="overflow-y:auto;height:500px;" class="w3-margin-top">
      <?php
      $crow2 = $obj->executequery("select * from m_product_category where checked_status='1' order by catname asc");
      foreach ($crow2 as $cres2) {
        $pcatid = $cres2['pcatid'];
      ?>
        <div id="<?php echo $cres2['pcatid']; ?>" class=" city w3-animate-top w3-margin-top">
          <div class="w3-panel w3-gyellow w3-small w3-card w3-round">
            <h5><?php echo strtoupper($cres2['catname']); ?></h5>
          </div>
          <?php
          $crow1 = $obj->executequery("select * from m_product where pcatid = '$pcatid' and checked_status='1' order by prodname asc");
          foreach ($crow1 as $cres1) {

            $prodname = $cres1['prodname'];

            $imgname = $cres1['imgname'];
            if ($imgname == "") {
              $imgname = "default.jpg";
            }
          ?>
            <div class="w3-card w3-sand w3-round" style="padding:5px;margin-bottom:4px;">
              <div class="w3-row">
                <div class="w3-col s4">
                  <img src="../admin/uploaded/img/<?php echo $imgname; ?>" style="width:105px;height:105px;">
                </div>
                <div class="w3-col s8">
                  <h6 style="padding-left:5px;font-size: 14px;" class="w3-text-black"><?php echo strtoupper($prodname); ?></h6>
                  <p style="line-height:1.2;" class="w3-small">
                    <?php echo $cres1['description']; ?><br>
                    <span class="rupee w3-right">₹ <?php echo number_format($cres1['rate'], 2); ?></span>
                  </p>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
    <div class="w3-margin-bottom"></div>
  </div>

  <script>
    function openCity(evt, cityName) {
      var i, x, tablinks;
      x = document.getElementsByClassName("city");
      for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablink");
      for (i = 0; i < x.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
      }
      document.getElementById(cityName).style.display = "block";
      evt.currentTarget.className += " w3-red";
    }

    function refreash() {
      location.reload();
    }
  </script>

</body>

</html>