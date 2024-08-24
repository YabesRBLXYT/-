<?php
session_start();
$authenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
        a {
            text-decoration: none;
            color: #1a0dab;
        }
        a:hover {
            text-decoration: underline;
        }
        #content {
            display: <?php echo $authenticated ? 'block' : 'none'; ?>;
        }
        #passwordPrompt {
            display: <?php echo $authenticated ? 'none' : 'flex'; ?>;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        #passwordPrompt input {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div id="passwordPrompt">
        <h1>Enter Password</h1>
        <input type="password" id="password" placeholder="Password">
        <button onclick="checkPassword()">Submit</button>
        <p id="errorMessage" style="color: red; display: none;">Incorrect password, please try again.</p>
    </div>
    <div id="content">
        <h1>Link List</h1>
        <ul id="linkList"></ul>
    </div>

    <script>
        function checkPassword() {
            const password = document.getElementById('password').value;
            fetch('password.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ password })
            })
            .then(response => response.json())
            .then(data => {
                if (data.authenticated) {
                    document.getElementById('passwordPrompt').style.display = 'none';
                    document.getElementById('content').style.display = 'block';
                    loadLinks();
                } else {
                    document.getElementById('errorMessage').style.display = 'block';
                }
            })
            .catch(error => console.error('Error checking password:', error));
        }

        function loadLinks() {
            fetch('data.json')
                .then(response => response.json())
                .then(data => {
                    const linkList = document.getElementById('linkList');
                    for (const key in data) {
                        if (data.hasOwnProperty(key)) {
                            const link = data[key];
                            const listItem = document.createElement('li');
                            const anchor = document.createElement('a');
                            anchor.href = link.url;
                            anchor.textContent = link.name;
                            anchor.target = '_blank'; // Open links in a new tab
                            listItem.appendChild(anchor);
                            linkList.appendChild(listItem);
                        }
                    }
                })
                .catch(error => console.error('Error loading JSON data:', error));
        }
    </script>
</body>
</html>
