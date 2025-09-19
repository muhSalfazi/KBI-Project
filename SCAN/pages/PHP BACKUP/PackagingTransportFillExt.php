<table width="100%" border="1">
  <div>
    <thead>
      <th class="text-center" style="width:1px;">Spec(mm)</th>
      <th class="text-center" style="width:1px;">Price</th>
      <th class="text-center" style="width:1px;">Est Qty</th>
      <th class="text-center" style="width:1px;">Qty/Box</th>
      <th class="text-center" style="width:1px;">Dep Qty</th>
      <th class="text-center" style="width:1px;">Price/Pc</th>
      <th class="text-center" style="width:1px;">Type Packging</th>
    </thead>
    <?php
      $loop = 1;
    ?>
    <tr>
      <td class="text-center">
        <input name="spec[]" id="spec<?php echo $loop;?>" type="text" style="width:125px;" required/>
      </td>
      <td class="text-center">
        <input name="price[]" id="price<?php echo $loop;?>" type="text" style="width:125px;" required/>
      </td>
      <td class="text-center">
        <input name="estqty[]" id="estqty<?php echo $loop;?>" type="text" style="width:125px;" required/>
      </td>
      <td class="text-center">
        <input name="qtybox[]" id="qtybox<?php echo $loop;?>" type="text" style="width:125px;" required/>
      </td>
      <td class="text-center">
        <input name="depqty[]" id="depqty<?php echo $loop;?>" type="text" style="width:125px;" readonly/>
      </td>
      <td class="text-center">
        <input name="pricepc[]" id="pricepc<?php echo $loop;?>" type="text" style="width:125px;" readonly/>
      </td>
      <td class="text-center">
        <select id="packging<?php echo $loop;?>" name="packging[]" style="width:125px;" onchange="getFormula(<?php echo $loop;?>)" required>
          <option value="" disabled selected>- Choose Type -</option>
          <?php
            $QuerySelectAllTypePackaging = $mysqli->query("SELECT * FROM tbl_type_packaging ORDER BY id_type_packaging ASC");
            while($ResultQuerySelectAllTypePackaging = mysqli_fetch_array($QuerySelectAllTypePackaging)) {
          ?>
          <option value="<?php echo $ResultQuerySelectAllTypePackaging['formula_price_or_pc'].','.$ResultQuerySelectAllTypePackaging['formula_dep_qty'].','.$ResultQuerySelectAllTypePackaging['id_type_packaging'] ?>"><?php echo $ResultQuerySelectAllTypePackaging['type_packaging'] ?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <?php
      while($loop < 30){
        $loop++;
    ?>
    <tr>
      <td class="text-center">
        <input name="spec[]" id="spec<?php echo $loop;?>" type="text" style="width:125px;"/>
      </td>
      <td class="text-center">
        <input name="price[]" id="price<?php echo $loop;?>" type="text" style="width:125px;"/>
      </td>
      <td class="text-center">
        <input name="estqty[]" id="estqty<?php echo $loop;?>" type="text" style="width:125px;"/>
      </td>
      <td class="text-center">
        <input name="qtybox[]" id="qtybox<?php echo $loop;?>" type="text" style="width:125px;"/>
      </td>
      <td class="text-center">
        <input name="depqty[]" id="depqty<?php echo $loop;?>" type="text" style="width:125px;" readonly/>
      </td>
      <td class="text-center">
        <input name="pricepc[]" id="pricepc<?php echo $loop;?>" type="text" style="width:125px;" readonly/>
      </td>
      <td class="text-center">
        <select id="packging<?php echo $loop;?>" name="packging[]" style="width:125px;" onchange="getFormula(<?php echo $loop;?>)">
          <option value="" disabled selected>- Choose Type -</option>
          <?php
            $QuerySelectAllTypePackaging = $mysqli->query("SELECT * FROM tbl_type_packaging ORDER BY id_type_packaging ASC");
            while($ResultQuerySelectAllTypePackaging = mysqli_fetch_array($QuerySelectAllTypePackaging)) {
          ?>
          <option value="<?php echo $ResultQuerySelectAllTypePackaging['formula_price_or_pc'].','.$ResultQuerySelectAllTypePackaging['formula_dep_qty'].','.$ResultQuerySelectAllTypePackaging['id_type_packaging'] ?>"><?php echo $ResultQuerySelectAllTypePackaging['type_packaging'] ?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <?php
      }
    ?>
  </div>
</table>