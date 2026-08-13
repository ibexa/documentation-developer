/**
 * Page Actions JavaScript
 * Handles functionality for page action buttons (Copy as Markdown, View as Markdown, Edit on GitHub)
 */

async function copyPageForLLM() {
  const mdPath = document.querySelector('meta[name="markdown-path"]').content;

  try {
    const response = await fetch(mdPath);
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    const markdownContent = await response.text();
    await navigator.clipboard.writeText(markdownContent);
    showButtonFeedback('success', 'Copied!');
  } catch (error) {
    console.error('Failed to copy content:', error);
    window.open(mdPath, '_blank');
    showButtonFeedback('info', 'Opened in tab');
  }
}

function showButtonFeedback(type, message) {
  const button = document.querySelector('button[onclick="copyPageForLLM()"]');
  if (!button) return;

  const originalHTML = button.innerHTML;
  button.innerHTML = `${message}`;

  if (type === 'success') {
    button.classList.add('page-action-btn--success');
  } else if (type === 'info') {
    button.classList.add('page-action-btn--info');
  }

  setTimeout(() => {
    button.innerHTML = originalHTML;
    button.classList.remove('page-action-btn--success', 'page-action-btn--info');
  }, 2000);
}

document.addEventListener('DOMContentLoaded', function() {
  const pageActions = document.getElementById('page-actions');
  const firstH1 = document.querySelector('.bootstrap-iso h1, h1');

  if (pageActions && firstH1) {
    // If h1 is inside a special header container (e.g. release-notes-header),
    // insert page-actions after that container so it doesn't disrupt the header layout.
    const headerContainer = firstH1.closest('.release-notes-header');
    const anchor = headerContainer || firstH1;
    anchor.insertAdjacentElement('afterend', pageActions);
    pageActions.classList.add('page-actions--visible');
  }
});
