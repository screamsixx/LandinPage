module.exports = {
  // CORRECT: This points your API specifically to your email sender script.
  apiUrl: process.env.API_URL || "https://pascalsolutionsti.com/php/email-sender.php",
  
  // IMPORTANT: This should be your website's root URL, NOT the PHP script.
  // This is used for general linking, asset loading, etc., within your site.
  appUrl: process.env.APP_URL || "https://pascalsolutionsti.com", 
};