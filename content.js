// content.js

function getSubtotal() {
  const subtotalLabels = ['subtotal', 'total']; // Common labels for subtotal
  const regex = /\$?(\d+(\.\d{1,2})?)/; // Match numerical values with or without dollar sign
  
  // Find all elements containing subtotal labels
  const elementsWithLabels = Array.from(document.querySelectorAll('*'))
    .filter(element => subtotalLabels.some(label => element.textContent.toLowerCase().includes(label)));

  // Search for numerical values near elements with subtotal labels
  for (const element of elementsWithLabels) {
    const siblingText = element.nextSibling ? element.nextSibling.textContent : '';
    const match = siblingText.match(regex);
    if (match) {
      const subtotal = parseFloat(match[1]);
      return isNaN(subtotal) ? 0 : subtotal;
    }
  }

  return 0; // Return 0 if subtotal not found
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
