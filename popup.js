// popup.js
document.getElementById('goals-form').addEventListener('submit', function(event) {
  event.preventDefault();
  const spendingLimit = document.getElementById('spending-limit').value;
  console.log('Spending Limit:', spendingLimit);
  if (!spendingLimit || isNaN(parseFloat(spendingLimit))) {
    console.error('Invalid spending limit!');
    return;
  }
  chrome.storage.sync.set({
    spendingLimit: spendingLimit
  }, function() {
    console.log('Spending Limit saved successfully!');
    alert('Goals saved!');
  });
});

document.addEventListener('DOMContentLoaded', function() {
  chrome.storage.sync.get(['spendingLimit'], function(data) {
    if (chrome.runtime.lastError) {
      console.error(chrome.runtime.lastError.message);
      return;
    }
    const spendingLimit = data.spendingLimit;
    console.log('Spending Limit (after retrieval):', spendingLimit);
    if (spendingLimit) {
      document.getElementById('spending-limit').value = spendingLimit;
    }
  });
});

