$("#datePicker").on("change", function(e) {

    displayDateFormat($(this), '#datePickerLbl', $(this).val());
  
  });
  
  function displayDateFormat(thisElement, datePickerLblId, dateValue) {
  
    $(thisElement).css("color", "rgba(0,0,0,0)")
      .siblings(`${datePickerLblId}`)
      .css({
        position: "absolute",
        left: "10px",
        top: "3px",
        width: $(this).width()
      })
      .text(dateValue.length == 0 ? "" : (`${getDateFormat(new Date(dateValue))}`));
  
  }
  
  function getDateFormat(dateValue) {
  
    let d = new Date(dateValue);
  
    // this pattern dd/mm/yyyy
    // you can set pattern you need
    let dstring = `${("0" + d.getDate()).slice(-2)}/${("0" + (d.getMonth() + 1)).slice(-2)}/${d.getFullYear()}`;
  
    return dstring;
  }