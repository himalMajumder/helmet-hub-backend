<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1e293b;
        }

        .container {
            padding: 1.5rem;
            width: 100%;
            max-width: 42rem;
        }

        .error-box {
            text-align: center;
            background: white;
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .icon {
            background-color: #fee2e2;
            color: #ef4444;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
        }

        .error-image {
            width: 100%;
            max-width: 400px;
            height: auto;
            border-radius: 0.75rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #1e293b;
        }

        .message {
            font-size: 1.125rem;
            color: #64748b;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background-color: #4f46e5;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .back-button:hover {
            background-color: #4338ca;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
        }

        .back-button svg {
            width: 20px;
            height: 20px;
        }

        .error-code {
            margin-top: 2rem;
            font-size: 0.875rem;
            color: #94a3b8;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="error-box">
            <!-- Shield Icon -->
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    <path d="M3.6 9h16.8" />
                    <path d="M12 2v20" />
                </svg>
            </div>

            <!-- Error Image -->
            <img src="https://images.unsplash.com/photo-1633265486064-086b219458ec?w=800&auto=format&fit=crop&q=80"
                alt="Security Illustration" class="error-image">

            <!-- Error Message -->
            <h1>Access Denied</h1>
            <p class="message">You are not authorized to access this data. Please contact your administrator if you
                believe this is a mistake.</p>

            <!-- Action Button -->
            <button onclick="history.back()" class="back-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
                Go Back
            </button>

            <!-- Error Code -->
            <p class="error-code">Error Code: 401 Unauthorized</p>
        </div>
    </div>
</body>

</html>
