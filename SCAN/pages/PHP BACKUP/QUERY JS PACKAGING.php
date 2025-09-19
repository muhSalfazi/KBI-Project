<script type="text/javascript">
      function getFormula(){
      	//ambil data formula dri combo box
        var formula=document.getElementById("packging").value;
        var forecastPerMonth = <?php echo $ResultQuerySelectRFQForm['volume']; ?>;

        //ambil data yang di input user
        var getprice=document.getElementById("price").value;
        var getestqty=document.getElementById("estqty").value;
        var getqtybox=document.getElementById("qtybox").value;

        //membelah data formula dri get combo box
        var formulaPrice = new String(formula.split(",",1));
        var lengthformulaPrice = formulaPrice.length;
        var formulaDepQty = formula.substr(lengthformulaPrice+1);

        //Variabel Value
        var depqty = null;
        var pricepc = null;

        //Formula
        if (formulaDepQty != null) {
        	depqty = forecastPerMonth * forecastPerMonth;
		}

        if (formulaPrice != null && depqty != null) {
        	pricepc = getprice * getestqty * formulaPrice / depqty;
		}else if (formulaPrice == null && depqty != null){
			pricepc = getprice * getestqty / depqty;
		}else if (formulaPrice == null && depqty == null){
			pricepc = getprice * getestqty / getqtybox;
		}

		//Input nilai dri hasil rumus
		if(depqty != null){
			document.getElementById("depqty").value=formulaDepQty;
		}
		document.getElementById("depqty").value=formulaDepQty;
		document.getElementById("pricepc").value=formulaDepQty;

		if(pricepc != null){
			document.getElementById("pricepc").value=formulaPrice;
		}
        
      }
    </script>