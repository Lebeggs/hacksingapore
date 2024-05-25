document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('save').addEventListener('click', () => {
    let goals = document.getElementById('goals').value.split(',').map(goal => goal.trim());
    chrome.storage.sync.set({ retirementGoals: goals }, () => {
      alert('Goals saved successfully!');
    });
  });

  chrome.storage.sync.get('retirementGoals', (data) => {
    if (data.retirementGoals) {
      document.getElementById('goals').value = data.retirementGoals.join(', ');
    }
  });
});
