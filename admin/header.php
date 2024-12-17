<style>
    /* Header */
    .header {
            background: linear-gradient(to right, #320A2C, #6A1B47);
            color: white;
            padding: 20px 30px;
            margin-left: 250px;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
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
        <h1>Welcome, Admin!</h1>
        <button onclick="window.location.href='../login.php'">
            <i class="fas fa-sign-out-alt"></i> Log Out
        </button>
    </div>