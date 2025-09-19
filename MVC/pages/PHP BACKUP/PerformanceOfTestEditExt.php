<tr>
  <td class="text-center">
    <input name="testitem[]" id="testitem<?php echo $loop;?>" type="text" style="width:180px;"  />
  </td>
  <td class="text-center">
    <input name="method[]" id="method<?php echo $loop;?>" type="text" style="width:180px;" />
  </td>
  <td class="text-center">
    <input name="qty[]" id="qty<?php echo $loop;?>" type="text" style="width:180px;"  />
  </td>
  <td class="text-center">
    <input name="unit[]" id="unit<?php echo $loop;?>" type="text" style="width:180px;" onkeyup="getValueTotal(<?php echo $loop;?>)"  />
  </td>
  <td class="text-center">
    <input name="total[]" id="total<?php echo $loop;?>" type="text" style="width:180px;" readonly  />
  </td>
</tr>
<?php
  while($loop < 15){
    $loop++;
?>
<tr>
  <td class="text-center">
    <input name="testitem[]" id="testitem<?php echo $loop;?>" type="text" style="width:180px;"  />
  </td>
  <td class="text-center">
    <input name="method[]" id="method<?php echo $loop;?>" type="text" style="width:180px;" />
  </td>
  <td class="text-center">
    <input name="qty[]" id="qty<?php echo $loop;?>" type="text" style="width:180px;"  />
  </td>
  <td class="text-center">
    <input name="unit[]" id="unit<?php echo $loop;?>" type="text" style="width:180px;" onkeyup="getValueTotal(<?php echo $loop;?>)"  />
  </td>
  <td class="text-center">
    <input name="total[]" id="total<?php echo $loop;?>" type="text" style="width:180px;" readonly />
  </td>
</tr>
<?php
  }
?>