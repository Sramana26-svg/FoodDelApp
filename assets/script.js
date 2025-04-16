// Fetch wrapper with error handling
async function apiFetch(url, options = {}) {
  const res = await fetch(url, options);
  if (!res.ok) {
    const err = await res.json();
    alert(err.error || 'Something went wrong');
    throw new Error(err.error || 'Request failed');
  }
  return res.json();
}

// Check if logged in
async function getProfile() {
  try {
    const user = await apiFetch('../api/get_profile.php');
    return user;
  } catch {
    alert('Please login to continue.');
    window.location.href = 'login.html';
  }
}

// Logout
function logout() {
  fetch('../api/logout.php')
    .then(() => {
      alert('Logged out');
      location.href = 'login.html';
    });
}
