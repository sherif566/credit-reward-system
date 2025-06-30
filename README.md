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
Then access the app at: [http://localhost:8000](http://localhost:8000)

---

## 🔐 Authentication

This project uses **JWT Authentication**. Use `/api/login` to obtain a token:

```json
POST /api/login
{
  "email": "admin@example.com",
  "password": "password"
}
```

Then attach the token to protected requests:

```http
Authorization: Bearer <your-jwt-token>
```

---

## 📬 API Endpoints

### ✅ Auth

* `POST /api/register`
* `POST /api/login`
* `POST /api/logout`

### 💰 Credit & Purchase

* `POST /api/purchase`
* `GET /api/products/search`
* `POST /api/redeem/{product_id}`

### 🧑‍💼 Admin (requires admin + JWT auth)

* `POST /api/products/add`
* `PUT /api/products/update/{id}`
* `DELETE /api/products/delete/{id}`
* `POST /api/offerpool/{id}`
* `DELETE /api/offerpool/delete/{id}`
* `POST /api/credit-packages/add`
* `PUT /api/credit-packages/update/{id}`
* `DELETE /api/credit-packages/delete/{id}`

### 🤖 AI

* `POST /api/ai/recommendation`
  Requires OpenAI API key in `.env` as `OPENAI_API_KEY`

---

## ⚙️ Tech Stack

* Laravel 12.x (Latest)
* MySQL 8 (via Docker)
* JWTAuth (Tymon package)
* OpenAI API (optional)
* Docker / Docker Compose

---

## 🔑 .env Example

```env
APP_NAME=CreditSystem
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=credit_system
DB_USERNAME=user
DB_PASSWORD=password

JWT_SECRET=your_jwt_secret
OPENAI_API_KEY=sk-...


