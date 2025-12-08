<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
</head>
<body>
  <p>Hi {{ $name }},</p>

  <p>Thank you for contacting us. Below is our reply:</p>

  <blockquote>{{ $reply }}</blockquote>

  <hr />
  <p>Your original message:</p>
  <blockquote>{{ $original }}</blockquote>

  <p>Regards,<br/>Eco Creations and Products</p>
</body>
</html>
