// background.js
chrome.tabs.onUpdated.addListener((tabId, changeInfo, tab) => {
  if (changeInfo.status === 'complete' && tab.url) {
    const shoppingSites = ["shoppee.sg", "amazon.com", "ebay.com", "etsy.com", "luxury.com"];
    const isShoppingSite = shoppingSites.some(site => tab.url.includes(site));

    if (isShoppingSite) {
      chrome.scripting.executeScript({
        target: { tabId: tabId },
        files: ["content.js"]
      });
    }
  }
});