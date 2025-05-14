<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add VIP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/vue@3.2.36/dist/vue.global.js"></script>
  <style>
    body {
      background-color: var(--bs-body-bg);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .card {
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }
    .form-label, .form-control {
      text-align: left;
    }
    .checkmark {
      display: inline-block;
      width: 1.5rem;
      height: 1.5rem;
      background-color: #eee;
      border-radius: 0.25rem;
    }
    .btn-group {
      display: flex;
      gap: 10px;
    }
    #themeToggle {
      position: absolute;
      top: 1rem;
      right: 1rem;
    }
  </style>
</head>
<body>
<button id="themeToggle" class="btn btn-sm btn-outline-dark">🌚/☀️</button>
<div id="app" class="card">
  <h3 class="text-center mb-4">Add VIP</h3>
  <form @submit.prevent="addVip">
    <div class="mb-3">
      <label for="name" class="form-label">Name:</label>
      <input type="text" id="name" class="form-control" v-model="vip.name" required>
    </div>
    <div class="mb-3">
      <label for="steamid" class="form-label">SteamID:</label>
      <input type="text" id="steamid" class="form-control" v-model="vip.steamid" required>
    </div>
    <div class="mb-3">
      <label for="code" class="form-label">VIP Code:</label>
      <div class="input-group">
        <input type="text" id="code" class="form-control" v-model="vip.code" required>
        <button type="button" class="btn btn-outline-secondary" @click="generateCode">Generate</button>
      </div>
    </div>
    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" id="directVip" v-model="directVip">
      <label class="form-check-label" for="directVip">Player will be directly VIP</label>
    </div>
    <div v-if="directVip" class="mb-3">
      <label for="expire-options" class="form-label">Expire Date:</label>
      <select id="expire-options" class="form-select mb-2" v-model="expireOption" @change="setExpireDate">
        <option value="1D">1 Day</option>
        <option value="1W">1 Week</option>
        <option value="1M">1 Month</option>
        <option value="custom">Custom Expire Date</option>
      </select>
      <input type="datetime-local" class="form-control" v-if="expireOption === 'custom'" v-model="vip.expire" />
      <div class="mt-2">
        <label for="vip_group" class="form-label">Admin Group (default: vip):</label>
        <input type="text" id="vip_group" class="form-control" v-model="vip.vip_group" placeholder="vip">
      </div>
    </div>
    <div class="btn-group mt-4">
      <button type="submit" class="btn btn-outline-success w-50">Add To VIP List</button>
      <a href="list_vips.php" class="btn btn-outline-primary w-50">Back</a>
    </div>
    <a href="logout.php" class="btn btn-outline-secondary d-block mt-3">Logout</a>
  </form>
</div>

<script>
  const html = document.documentElement;
  const toggle = document.getElementById('themeToggle');

  // Apply saved theme on load
  const savedTheme = localStorage.getItem('theme') || 'light';
  html.setAttribute('data-bs-theme', savedTheme);
  toggle.textContent = savedTheme === 'dark' ? '🌚/☀️' : '☀️/🌚';

  toggle.addEventListener('click', () => {
    const current = html.getAttribute('data-bs-theme');
    const next = current === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-bs-theme', next);
    localStorage.setItem('theme', next);
    toggle.textContent = next === 'dark' ? '🌚/☀️' : '☀️/🌚';
  });
  Vue.createApp({
    data() {
      return {
        vip: {
          name: '',
          steamid: '',
          code: '',
          expire: null,
          vip_group: 'vip'
        },
        directVip: false,
        expireOption: '1D'
      };
    },
    methods: {
      generateCode() {
        this.vip.code = Math.random().toString(36).substr(2, 10);
      },
      addVip() {
        const formData = new FormData();
        formData.append('name', this.vip.name);
        formData.append('steamid', this.vip.steamid);
        formData.append('code', this.vip.code);
        formData.append('used', this.directVip ? '1' : '0');

        if (this.directVip) {
          let expireDate = new Date();
          switch (this.expireOption) {
            case '1D': expireDate.setDate(expireDate.getDate() + 1); break;
            case '1W': expireDate.setDate(expireDate.getDate() + 7); break;
            case '1M': expireDate.setMonth(expireDate.getMonth() + 1); break;
            case 'custom': expireDate = new Date(this.vip.expire); break;
          }
          formData.append('expire', this.formatDateTime(expireDate));
          formData.append('vip_group', this.vip.vip_group);
        } else {
          formData.append('expire', '');
          formData.append('vip_group', '');
        }

        fetch('process_vip.php', {
          method: 'POST',
          body: formData
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            alert('VIP added successfully!');
            this.resetVipForm();
          } else {
            alert('Error adding VIP: ' + data.message);
          }
        })
        .catch(console.error);
      },
      resetVipForm() {
        this.vip = { name: '', steamid: '', code: '', expire: null, vip_group: 'vip' };
        this.directVip = false;
        this.expireOption = '1D';
      },
      setExpireDate() {
        const now = new Date();
        switch (this.expireOption) {
          case '1D': now.setDate(now.getDate() + 1); break;
          case '1W': now.setDate(now.getDate() + 7); break;
          case '1M': now.setMonth(now.getMonth() + 1); break;
          default: return;
        }
        this.vip.expire = this.formatDateTime(now);
      },
      formatDateTime(date) {
        return date.toISOString().slice(0, 16);
      }
    }
  }).mount('#app');
</script>
</body>
</html>
