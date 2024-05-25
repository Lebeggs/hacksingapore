chrome.runtime.onMessage.addListener((request, sender, sendResponse) => {
    if (request.message === 'check_website') {
      // Extract website content
      let pageContent = document.body.innerText;
  
      // Retrieve stored goals from storage
      chrome.storage.sync.get(['retirementGoals'], function(result) {
        const goalsKeywords = result.retirementGoals || [];
  
        // Check if page content matches any of the keywords
        let matchesGoals = goalsKeywords.some(keyword => pageContent.includes(keyword));
  
        // Notify the user if the page matches goals
        if (matchesGoals) {
          alert('This website contains information relevant to your retirement goals!');
        }
      });
    }
  });
  