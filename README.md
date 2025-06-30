# 🎁 Reward-Based Credit System

A scalable Laravel-based system where users can purchase credits, earn reward points, and redeem them for products. Admins can manage product offers and credit packages. Features efficient search and an optional AI-based product recommendation engine.

---

## 📦 Features

### ✅ For Users
- Register/Login using JWT authentication
- Purchase credit bundles (earn reward points)
- Redeem points for products from the **Offer Pool**
- Search products (keyword-based, paginated)

### 🛠️ For Admins
- Add/Edit/Delete Products
- Assign products to Offer Pool
- Add/Edit Credit Packages and associated reward points

### 🔍 Product Search
- Route: `GET /api/products/search?query=...`
- Supports keyword-based search across product name and category
- Efficient and paginated

### 🤖 (Bonus) AI Recommendation
- Route: `POST /api/ai/recommendation`
- Returns the best product a user can redeem based on their reward points and Offer Pool
- Powered by OpenAI (requires API key)

---

## 🚀 Getting Started

### Prerequisites
- Docker & Docker Compose installed
- GitHub Personal Access Token (for pushing to GitHub, if needed)
- OpenAI API Key (if using AI recommendation)

### 🐳 Run with Docker

```bash
# Clone the repository
git clone https://github.com/yourusername/credit-reward-system.git
cd credit-reward-system

# Build and run containers
docker-compose up --build

# Install Laravel dependencies
docker exec -it <app-container-name> composer install

# Setup the app
docker exec -it <app-container-name> php artisan migrate --seed
docker exec -it <app-container-name> php artisan key:generate
