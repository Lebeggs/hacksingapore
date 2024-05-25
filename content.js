// content.js

console.log('Content script injected');

function getSubtotal() {
  const subtotalElement = document.querySelector('.sc-price');
  if (subtotalElement) {
    const subtotalText = subtotalElement.innerText || subtotalElement.textContent;
    const subtotal = parseFloat(subtotalText.replace(/[^0-9.]+/g,""));
    return isNaN(subtotal) ? 0 : subtotal;
  }
  return 0;
}


function checkSpendingLimit() {
  chrome.storage.sync.get(['spendingLimit'], function(data) {
    console.log('Retrieved spending limit:', data.spendingLimit);
    const spendingLimit = parseFloat(data.spendingLimit);
    if (!isNaN(spendingLimit)) {
      const subtotal = getSubtotal();
      console.log('Subtotal:', subtotal);
      if (subtotal > spendingLimit) {
        alert(`Warning: Your subtotal of $${subtotal} exceeds your spending limit of $${spendingLimit}!`);
      }
    } else {
      console.log('Invalid spending limit:', data.spendingLimit);
    }
  });
}

// Call checkSpendingLimit when the script is injected
checkSpendingLimit();
