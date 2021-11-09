const MAX_USERNAME_LENGTH = 20;
const MAX_PASSWORD_LENGTH = 20;
const MAX_ACTUALNAME_LENGTH = 15;
const MAX_POSTNAME_LENGTH = 20;
const MAX_DESCRIPTION_LENGTH = 150;
const MAX_BIO_LENGTH = 150;

function validateRegisterForm() {
  const registerForm = document.forms["register"];
  const actualName = registerForm["real-name"].value;
  const username = registerForm["username"].value;
  const password = registerForm["password"].value;

  if (actualName.length > MAX_ACTUALNAME_LENGTH) {
    alert(
      `Your actual name is too long | CHARACTER: [ACTUAL NAME] ${actualName.length} / ${MAX_ACTUALNAME_LENGTH}`
    );
    return false;
  }

  if (username.length > MAX_USERNAME_LENGTH) {
    alert(
      `Your username is too long | CHARACTER [USERNAME]: ${username.length} / ${MAX_USERNAME_LENGTH}`
    );
    return false;
  }

  if (password.length > MAX_PASSWORD_LENGTH) {
    alert(
      `Your password is too long | CHARACTER [PASSWORD]: ${password.length} / ${MAX_PASSWORD_LENGTH}`
    );
    return false;
  }
}

function validateSettings() {
  const settingsForm = document.forms["settings"];
  const bio = settingsForm["change-bio"].value;

  if (bio.length > MAX_BIO_LENGTH) {
    alert(
      `Your bio is too long | CHARACTER [BIO]: ${bio.length} / ${MAX_BIO_LENGTH}`
    );
    return false;
  }
}

function validateCreatePost() {
  const createForm = document.forms["create"];
  const postName = createForm["post-name"].value;
  const postDescription = createForm["post-description"].value;

  if (postName.length > MAX_POSTNAME_LENGTH) {
    alert(
      `Your post title is too long | CHARACTER [POST TITLE]: ${postName.length} / ${MAX_POSTNAME_LENGTH}`
    );
    return false;
  }

  if (postDescription.length > MAX_POSTDESCRIPTION_LENGTH) {
    alert(
      `Your post description is too long | CHARACTER [POST DESCRIPTION]: ${postDescription.length} / ${MAX_POSTDESCRIPTION_LENGTH}`
    );
    return false;
  }
}
