<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width,
				initial-scale=1.0">
    <title>
        404 Page Not Found
    </title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #000000;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .error-container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 5rem;
            color: #12444F;
        }

        p {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 20px;
        }

        a {
            text-decoration: none;
            background-color: #12444F;
            color: #fff;
            padding: 10px 20px;
            border-radius: 3px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #0c5460;
        }

    </style>
</head>

<body>
<div class="error-container">
    <h1> 404 </h1>
    <p>
        Oops! Parece que esta página não existe
    </p>
    <a href="/home">
        Go Back to Home
    </a>
</div>
</body>

</html>
