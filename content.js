// This script injects a reminder popup into the page
const reminderPopup = document.createElement('div');
reminderPopup.innerHTML = `
  <div class="reminder-popup">
    <p>Remember your financial and retirement goals!</p>
  </div>
`;
document.body.appendChild(reminderPopup);

// Add some basic styles for the popup
const styles = document.createElement('style');
styles.innerHTML = `
  .reminder-popup {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #fff;
    border: 1px solid #ccc;
    padding: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    z-index: 10000;
  }
`;
document.head.appendChild(styles);
