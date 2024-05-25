document.getElementById('goals-form').addEventListener('submit', function(event) {
    event.preventDefault();
  
    const financialGoals = document.getElementById('financial-goals').value;
    const retirementGoals = document.getElementById('retirement-goals').value;
  
    chrome.storage.sync.set({
      financialGoals: financialGoals,
      retirementGoals: retirementGoals
    }, function() {
      alert('Goals saved!');
    });
  });
  
  document.addEventListener('DOMContentLoaded', function() {
    chrome.storage.sync.get(['financialGoals', 'retirementGoals'], function(data) {
      if (data.financialGoals) {
        document.getElementById('financial-goals').value = data.financialGoals;
      }
      if (data.retirementGoals) {
        document.getElementById('retirement-goals').value = data.retirementGoals;
      }
    });
  });
  