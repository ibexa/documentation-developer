/**
 * Page Actions JavaScript
 * Handles functionality for page action buttons (Copy for LLM, View as Markdown, Edit on GitHub)
 */

async function copyPageForLLM() {
  try {
    const mdPath = document.querySelector('meta[name="markdown-path"]').content;
    console.log('Fetching from path:', mdPath);

    let markdownContent;

    try {
      const response = await fetch(mdPath);
      if (response.ok) {
        markdownContent = await response.text();
      } else {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
    } catch (fetchError) {
      console.log('Direct fetch failed, trying GitHub fallback...');
      const editUrl = document.querySelector('meta[name="edit-url"]').content;
      const rawUrl = editUrl.replace('/edit/', '/raw/');
      
      try {
        const response = await fetch(rawUrl);
        if (response.ok) {
          markdownContent = await response.text();
        } else {
          const proxyUrl = `https://api.allorigins.win/get?url=${encodeURIComponent(rawUrl)}`;
          const proxyResponse = await fetch(proxyUrl);
          if (proxyResponse.ok) {
            const proxyData = await proxyResponse.json();
            markdownContent = proxyData.contents;
          } else {
            throw new Error('All fetch methods failed');
          }
        }
      } catch (githubError) {
        throw new Error('GitHub fallback failed');
      }
    }

    if (!markdownContent) {
      throw new Error('No content received');
    }

    await navigator.clipboard.writeText(markdownContent);
    showButtonFeedback('success', 'Copied!', '📋');

  } catch (error) {
    console.error('Failed to copy content:', error);

    try {
      const mdPath = document.querySelector('meta[name="markdown-path"]').content;
      window.open(mdPath, '_blank');
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
  button.innerHTML = `${icon} ${message}`;

  if (type === 'success') {
    button.style.background = '#d4edda';
    button.style.borderColor = '#c3e6cb';
    button.style.color = '#155724';
  } else if (type === 'error') {
    button.style.background = '#f8d7da';
    button.style.borderColor = '#f5c6cb';
    button.style.color = '#721c24';
  } else if (type === 'info') {
    button.style.background = '#d1ecf1';
    button.style.borderColor = '#bee5eb';
    button.style.color = '#0c5460';
  }

  setTimeout(() => {
    button.innerHTML = originalHTML;
    button.style.background = '';
    button.style.borderColor = '';
    button.style.color = '';
  }, 2000);
}

document.addEventListener('DOMContentLoaded', function() {
  console.log('Page actions initialized');

  const pageActions = document.getElementById('page-actions');
  const firstH1 = document.querySelector('.bootstrap-iso h1, h1');

  if (pageActions && firstH1) {
    firstH1.insertAdjacentElement('afterend', pageActions);
    pageActions.style.display = 'flex';
  }
});
