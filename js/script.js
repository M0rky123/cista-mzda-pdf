document.addEventListener("DOMContentLoaded", function () {
  function validateNumericInput(event) {
    const input = event.target.value;
    const isValid = /^[0-9]*$/.test(input);
    const span = event.target.nextElementSibling;
    if (!isValid) {
      event.target.value = input.slice(0, -1);
    }
    span.style.visibility = isValid ? "hidden" : "visible";
  }
  document.getElementById("gross_salary").addEventListener("input", validateNumericInput);
  document.getElementById("children").addEventListener("input", validateNumericInput);
});
