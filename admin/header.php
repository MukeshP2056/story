<style>
    :root {
            --primary-color: #1e272e;
            --secondary-color: #27ae60;
            --accent-color: #e84118;
            --gradient-primary: linear-gradient(to right, #640D5F, #B53471);
            --gradient-secondary: linear-gradient(to right, #640D5F, #FF6EC7);
            --background-color: #f1f2f6;
            --card-bg: #ffffff;
            --card-shadow: rgba(0, 0, 0, 0.15);
        }
    /* Header */
    .header {
            background: linear-gradient(to right, #320A2C, #6A1B47);
            color: white;
            padding: 20px 30px;
            margin-left: 250px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
        }

        .header h1 {
            font-size: 28px;
        }

        .header button {
            background: var(--gradient-secondary);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 16px !important;
            cursor: pointer;
            transition: all 0.3s;
            width: 10%;
        }

        .header button:hover {
            background: linear-gradient(to right, #640D5F, #0D0D5F);
            color: #fff;
            border: 1px solid #fff;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 200px;
            }

            .content {
                margin-left: 220px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 180px;
            }

            .content {
                margin-left: 190px;
            }

            .header h1 {
                font-size: 22px;
            }

            .dashboard-card h3 {
                font-size: 18px;
            }
        }

</style>

<!-- Header -->
    <div class="header">
        <h1> Welcome,Admin!</h1>
        <button onclick="window.location.href='../login.php'">
            <i class="fas fa-sign-out-alt"></i> Log Out
        </button>
    </div>