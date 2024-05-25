chrome.runtime.onMessage.addListener((request, sender, sendResponse) => {
  if (request.message === 'check_website') {
    let pageContent = document.body.innerText;

    chrome.storage.sync.get(['retirementGoals'], function(result) {
      const goalsKeywords = result.retirementGoals || [];

      let matchesGoals = goalsKeywords.some(keyword => pageContent.includes(keyword));

      if (matchesGoals) {
        chrome.runtime.sendMessage({
          type: 'show_notification',
          message: 'This website contains information relevant to your retirement goals!'
        });
      }
    });
  }
});

