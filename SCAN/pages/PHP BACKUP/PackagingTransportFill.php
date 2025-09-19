<?php
  $ds = DIRECTORY_SEPARATOR;
  $base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
  include_once("../connection.php");
  session_start();
  require_once("{$base_dir}pages{$ds}validate{$ds}AuthUser.php");

  require_once("{$base_dir}pages{$ds}core{$ds}header.php");
  require_once("{$base_dir}pages{$ds}core{$ds}sidebar.php");

  $IdUser = $_SESSION["id_user"];
?> 


<?php
if ($_GET['ID']) {
//validasi ID

  $IdRFQForm = $_GET['ID'];
?>

	<!-- Content -->
    <div class="row">

    	<!-- Title -->
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-file fa-fw""></i> Packaging Transport</h1>
      </div>
      <!-- End Title -->

      <br><br><br><br><br><br>

      <?php
        $QuerySelectRFQForm=mysqli_query($mysqli, "SELECT * FROM tbl_rfq INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer INNER JOIN tbl_user ON tbl_rfq.id_user = tbl_user.id_user INNER JOIN tbl_role ON tbl_user.id_role = tbl_role.id_role WHERE tbl_rfq.id_rfq = $IdRFQForm");
        $ResultQuerySelectRFQForm=mysqli_fetch_array($QuerySelectRFQForm);
        $ListPackaging = 1;
      ?>

      
      <form action="../pages/crud/PackagingTransport_Add.php" name="modal_popup" enctype="multipart/form-data" method="post">
      <table width="100%">
        <div>
          <tr>
            <td class="text-left">
              <label style="padding-right:69px;">Project Name</label>
              <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:350px;" value="<?php echo $ResultQuerySelectRFQForm['project_name']; ?>" disabled/>
            </td>
            <td class="text-left">
              <label style="padding-right:98px;">Issue Date</label>
              <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectRFQForm['issue_date']; ?>" disabled/>
            </td>
          </tr>
          <tr>
            <td class="text-left">
              <label style="padding-right:108px;">Part No</label>
              <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:350px;" value="<?php echo $ResultQuerySelectRFQForm['part_no']; ?>" disabled/>
            </td>
            <td class="text-left">
              <label style="padding-right:100px;">Part Name</label>
              <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectRFQForm['part_name']; ?>" disabled/>
            </td>
          </tr>
          <tr>
            <td class="text-left">
              <label style="padding-right:93px;">Car Name</label>
              <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:350px;" value="<?php echo $ResultQuerySelectRFQForm['car_name']; ?>" disabled/>
            </td>
            <td class="text-left">
              <label style="padding-right:107px;">End User</label>
              <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectRFQForm['end_user']; ?>" disabled/>
            </td>
          </tr>
          <tr>
            <td class="text-left">
              <label style="padding-right:24px;">Volume (Qty/month)</label>
              <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:350px;" value="<?php echo $ResultQuerySelectRFQForm['volume']; ?>" disabled/>
            </td>
            <td class="text-left">
              <label style="padding-right:55px;">Depreciation Qty</label>
              <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectRFQForm['depreciation_qty']; ?>" disabled/>
            </td>
          </tr>
          <tr>
            <td class="text-left">
              <label style="padding-right:103px;">Material</label>
              <?php 
                $value = explode(',', $ResultQuerySelectRFQForm['id_material']); 
                $QuerySelectMaterial=mysqli_query($mysqli, "SELECT * FROM tbl_material WHERE tbl_material.id_material = ".$value[0]."");
                $ResultQuerySelectMaterial=mysqli_fetch_array($QuerySelectMaterial); 
              ?>
              <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:350px;" value="<?php echo $ResultQuerySelectMaterial['material']; ?>" disabled/>
            <td class="text-left">
              <label style="padding-right:35px;">Production Process</label>
              <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectRFQForm['production_process']; ?>" disabled/>
            </td>
          </tr>
          <tr>
            <td class="text-left">
              <label style="padding-right:91px;">Customer</label>
              <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:350px;" value="<?php echo $ResultQuerySelectRFQForm['customer_name']; ?>" disabled/>
            </td>
            <td class="text-left">
              <label style="padding-right:138px;">SOP</label>
              <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectRFQForm['sop']; ?>" disabled/>
            </td>
          </tr>
          <tr>
            <td class="text-left">
              <label style="padding-right:95px;">Due Date</label>
              <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:350px;" value="<?php echo $ResultQuerySelectRFQForm['deadline_de']; ?>" disabled/>
            </td>
            <td class="text-left">
              <label style="padding-right:143px;">PIC</label>
              <input name="pic" id="pic" type="text" class="form-group" style="width:280px;" required/>
            </td>
          </tr>
          <tr>
            <td class="text-left">
              <label style="padding-right:10px;">Document</label>
              <textarea class="form-control" name="notes" rows="2" cols="40" required="" disabled><?php echo $ResultQuerySelectRFQForm['name_doc']; ?></textarea>
            </td>
          </tr>
        </div>
      </table>
      <hr/>

      <div class="full-container">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#Packaging">Packaging</a></li>
          <li><a data-toggle="tab" href="#Transport">Transport</a></li>
        </ul>

        <input type="hidden" name="id" value="<?php echo $ResultQuerySelectRFQForm['id_rfq']; ?>" />
        <input type="hidden" name="projectname" value="<?php echo $ResultQuerySelectRFQForm['project_name']; ?>" />
        <input type="hidden" name="iduser" value="<?php echo $IdUser; ?>" />

        <div class="tab-content">
          <div id="Packaging" class="tab-pane fade in active">
            <!-- Table New -->
            <div class="row">
              <div class="col-lg-12">
                <div class="panel panel-default">
                  <div class="panel-heading">
                      Input Data Packaging
                  </div>

                  <div class="panel-body">
                    <div class="control-group after-add-packging">
                      <?php
                        include "PackagingTransportFillExt.php";
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Table New -->
          </div>
          <div id="Transport" class="tab-pane fade">
            <!-- Table New -->
            <div class="row">
              <div class="col-lg-12">
                <div class="panel panel-default">
                  <div class="panel-heading">
                      Input Data Transport
                  </div>
                  <div class="panel-body" style="padding-left:350px;">
                    <div class="form-group">
                      <label>Transportation</label>
                        <div class="input-group">
                          <input name="transportation" id="transportation" type="text" class="form-control" style="width:330px;" value="<?php echo $ResultQuerySelectRFQForm['delivery_destination']; ?><?php echo " - " ?><?php echo $ResultQuerySelectRFQForm['delivery_shceme']; ?>" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                      <label>1 Time Delivery(pcs)</label>
                        <div class="input-group">
                          <input name="timedelivery" id="timedelivery" type="text" class="form-control" style="width:280px;"/>
                          <input type="text" value="pcs" class="form-control" style="width:50px;" disabled/>
                        </div>
                    </div>
                    <div class="form-group">
                      <label>Tracking Capa Ratio(%)</label>
                        <div class="input-group">
                          <input name="tracaprat" id="tracaprat" type="text" class="form-control" style="width:280px;"/>
                          <input type="text" value="%" class="form-control" style="width:50px;" disabled/>
                        </div>
                    </div>
                    <div class="form-group">
                      <label>Transport Cost(IDR)</label>
                        <div class="input-group">
                          <input type="text" value="Rp." class="form-control" style="width:50px;" disabled/>
                          <input name="tracost" id="tracost" type="text" class="form-control" style="width:280px;" onkeyup="getValueTransportCostPcs()"/>
                        </div>
                    </div>
                    <div class="form-group">
                      <label>Transport Cost Pcs</label>
                        <div class="input-group">
                          <input type="text" value="Rp." class="form-control" style="width:50px;" disabled/>
                          <input name="tracostpc" id="tracostpc" type="text" class="form-control" style="width:280px;" readonly/>
                          <!-- <button class="btn btn-warning" type="button" style="width:40px;" onchange="getValueTransportCostPcs()"><i class="fa fa-refresh"></i></button> -->
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Table New -->
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-success" type="submit" style="width:110px;"><i class="fa fa-save"></i> SAVE</button>
          <a href="PackagingTransport.php" class="btn btn-danger" style="width:110px;" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> CANCEL</a>
        </div>
      </div>
      </form>
    </div>
    <!-- End Content -->

    <script type="text/javascript">
      $(document).ready(function () {
          $('.datepicker').datepicker({
              format: "yyyy-mm-dd",
              autoclose:true
          });
      });
    </script>

    <script type="text/javascript">
      function getFormula(loop){
        var formula=document.getElementById("packging".concat(loop)).value;
        var forecastPerMonth = <?php echo $ResultQuerySelectRFQForm['volume']; ?>;

        //ambil data yang di input user
        var getprice=document.getElementById("price".concat(loop)).value;
        var getestqty=document.getElementById("estqty".concat(loop)).value;
        var getqtybox=document.getElementById("qtybox".concat(loop)).value;

        //membelah data formula dri get combo box
        var formulaPrice = new String(formula.split(",",1));
        var lengthformulaPrice = formulaPrice.length;
        var formulaDepQty1 = formula.substr(lengthformulaPrice+1);
        var formulaDepQty = new String(formulaDepQty1.split(",",1));

        //Variabel Value
        var depqty = null;
        var pricepc = null;

        //Formula
        if (formulaDepQty != 0) {
          depqty = forecastPerMonth * formulaDepQty;
          depqty = depqty * 10 / 10;
        }else if (formulaDepQty == 0) {
          depqty = 0;
        }


        if (formulaPrice != 0 && formulaDepQty != 0) {
          pricepc = getprice * getestqty * formulaPrice / depqty;
          pricepc = pricepc * 10 / 10;
        }else if (formulaPrice == 0 && formulaDepQty != 0){
          pricepc = getprice * getestqty / depqty;
          pricepc = pricepc * 10 / 10;
        }else if (formulaPrice == 0 && formulaDepQty == 0){
          pricepc = getprice * getestqty / getqtybox;
          pricepc = pricepc * 10 / 10;
        }

        document.getElementById("pricepc".concat(loop)).value=pricepc;
        document.getElementById("depqty".concat(loop)).value=depqty;
        
      }
    </script>

    <script type="text/javascript">
      function getValueTransportCostPcs(){
        var gettimedelivery = document.getElementById("timedelivery").value;
        var gettracaprat    = document.getElementById("tracaprat").value;
        var gettracost      = document.getElementById("tracost").value;

        var values = gettracost * gettracaprat / gettimedelivery;

        document.getElementById("tracostpc").value=values;
        
      }
    </script>

<?php
}
?>

<?php
  require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?>   