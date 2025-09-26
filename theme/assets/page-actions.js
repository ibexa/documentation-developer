/**
 * Page Actions JavaScript
 * Handles functionality for page action buttons (Copy for LLM, etc.)
 */

async function copyPageForLLM() {
  try {
    // Get the raw URL, replacing master with 5.0 branch
    const url = document.querySelector('meta[name="edit-url"]').content;
    const rawUrl = url.replace('master', '5.0');
    console.log('Fetching from URL:', rawUrl);

    let markdownContent;

    // Try multiple approaches to get the content
    try {
      // Approach 1: Direct fetch (works if CORS is enabled)
      const response = await fetch(rawUrl);
      if (response.ok) {
        markdownContent = await response.text();
      } else {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
    } catch (corsError) {
      console.log('Direct fetch failed due to CORS, trying proxy...');

      // Approach 2: Use CORS proxy
      const proxyUrl = `https://api.allorigins.win/get?url=${encodeURIComponent(rawUrl)}`;
      const proxyResponse = await fetch(proxyUrl);

      if (proxyResponse.ok) {
        const proxyData = await proxyResponse.json();
        markdownContent = proxyData.contents;
      } else {
        throw new Error('Proxy fetch failed');
      }
    }

    if (!markdownContent) {
      throw new Error('No content received');
    }

    await navigator.clipboard.writeText(markdownContent);

    // Visual feedback - success
    showButtonFeedback('success', 'Copied!', '✅');

  } catch (error) {
    console.error('Failed to copy content:', error);

    // Try fallback: open raw URL in new tab
    try {
      const url = document.querySelector('meta[name="edit-url"]').content;
      const rawUrl = url.replace('master', '5.0');
      window.open(rawUrl, '_blank');
      showButtonFeedback('info', 'Opened in tab', '🔗');
    } catch (fallbackError) {
      showButtonFeedback('error', 'Failed', '❌');
    }
  }
}

function showButtonFeedback(type, message, icon) {
  const button = document.querySelector('button[onclick="copyPageForLLM()"]');
  if (!button) return;

  const originalHTML = button.innerHTML;
  button.innerHTML = `<div class="page-action-icon">${icon}</div>${message}`;

  // Apply styling based on type
  if (type === 'success') {
    button.style.background = '#d4edda';
    button.style.borderColor = '#c3e6cb';
  } else if (type === 'error') {
    button.style.background = '#f8d7da';
    button.style.borderColor = '#f5c6cb';
  } else if (type === 'info') {
    button.style.background = '#d1ecf1';
    button.style.borderColor = '#bee5eb';
  }

  // Reset after 2 seconds
  setTimeout(() => {
    button.innerHTML = originalHTML;
    button.style.background = '#f8f9fa';
    button.style.borderColor = '#e9ecef';
  }, 2000);
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
  console.log('Page actions initialized');

  // Move the page actions below the first h1 element
  const pageActions = document.getElementById('page-actions');
  const firstH1 = document.querySelector('.content-with-actions h1');

  if (pageActions && firstH1) {
    // Move the buttons to appear right after the first h1
    firstH1.insertAdjacentElement('afterend', pageActions);
    pageActions.style.display = 'flex'; // Ensure it's visible after moving
  }
});