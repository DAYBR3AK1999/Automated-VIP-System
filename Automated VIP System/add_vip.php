<?php
session_start();
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || ($_SESSION['role'] !== 'owner' && $_SESSION['role'] !== 'admin')) {
    header("Location: index.php");
    exit();
}

require 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add VIP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/vue@3.2.36/dist/vue.global.js"></script>
  <style>
    .form-control, .btn, .form-label {
      width: 100%; /* Set the width to 100% of the parent */
      max-width: 330px; /* Match the login page width or adjust as needed */
      margin: auto; /* Center align the form elements */
    }
    .form-group {
      margin-bottom: 1rem;
    }
    .btn-group {
      display: flex;
	  margin: 0 0.5rem; /* Add margin to the left and right of buttons for spacing */
      justify-content: space-between; /* Separate the buttons */
      gap: 10px; /* Add some space between buttons */
    }
	.btn-group .btn:first-child {
    margin-left: 0; /* Remove left margin for the first button */
  }
  .btn-group .btn:last-child {
    margin-right: 0; /* Remove right margin for the last button */
  }
    .btn-secondary {
      width: auto; /* Allow 'Generate' button to size itself */
    }
    #app {
      max-width: 330px;
      margin: auto;
    }
	.hidden {
      display: none;
    }
	.btn {
      border: 1px solid transparent; /* Add default border */
    }

    .btn:focus, .btn:hover {
      border: 1px solid #ddd; /* Change border color on hover/focus */
    }
	.direct-vip-checkbox {
      display: block;
      position: relative;
      padding-left: 35px;
      margin-bottom: 12px;
      cursor: pointer;
      font-size: 20px; /* Larger text size for better visibility */
    }
    .direct-vip-checkbox input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
      height: 0;
      width: 0;
    }
    .checkmark {
      position: absolute;
      top: 0;
      left: 0;
      height: 30px;
      width: 30px;
      background-color: #eee;
      border-radius: 2px;
	  display: flex;
      align-items: center;
      justify-content: center;
    }
    .direct-vip-checkbox:hover input ~ .checkmark {
      background-color: #ccc;
    }
    .direct-vip-checkbox input:checked ~ .checkmark {
      background-color: #2196F3;
    }
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }
	.direct-vip-checkbox input:checked ~ .checkmark:after {
      display: block;
      height: 10px;
      width: 10px;
      border-width: 0 2px 2px 0; /* Adjust border width for smaller checkmark */
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%) rotate(45deg);
    }
    .direct-vip-checkbox .checkmark:after {
      left: 5px;
      top: 5px;
      width: 5px;
      height: 5px;
      border: solid white;
      border-width: 0 3px 3px 0;
      -webkit-transform: rotate(45deg);
      -ms-transform: rotate(45deg);
      transform: rotate(45deg);
    }
	.generate-group {
      margin-bottom: 20px; /* Add more space below the generate button */
    }
  </style>
</head>
<body class="py-5 bg-light">
  <div class="container" id="app">
    <div class="row justify-content-center">
      <div class="col">
        <h1 class="text-center mb-4">Add VIP</h1>
        <form @submit.prevent="addVip" class="text-center">
          <div class="form-group">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" v-model="vip.name" required>
          </div>
          <div class="form-group">
            <label for="steamid" class="form-label">SteamID:</label>
            <input type="text" class="form-control" id="steamid" v-model="vip.steamid" required>
          </div>
          <div class="form-group">
            <label for="code" class="form-label">VIP Code:</label>
            <input type="text" class="form-control" id="code" v-model="vip.code" placeholder="Code" required>
          </div>
<div class="form-group generate-group">
      <button type="button" class="btn btn-secondary generate-btn" @click="generateCode">Generate</button>
      <label class="direct-vip-checkbox">Player will be directly VIP
        <input type="checkbox" v-model="directVip">
        <span class="checkmark"></span>
      </label>
    </div>
		  <div class="form-group" v-if="directVip">
            <label for="expire-options" class="form-label">Expire Date:</label>
            <select id="expire-options" class="form-control" v-model="expireOption" @change="setExpireDate">
              <option value="1D">1 Day</option>
              <option value="1W">1 Week</option>
              <option value="1M">1 Month</option>
              <option value="custom">Custom Expire Date</option>
            </select>

            <input type="datetime-local" class="form-control" v-if="expireOption === 'custom'" v-model="vip.expire" />
          </div>
<div class="btn-group" role="group" aria-label="Basic example">
  <button type="submit" class="btn btn-success">Add To VIP List</button>
  <a href='list_vips.php' class="btn btn-primary">Back</a>
</div>
          <div class="form-group">
            <a href='logout.php' class="btn btn-secondary d-block mt-2">Logout</a>
          </div>
        </form>
      </div>
    </div>
  </div>

<script>
Vue.createApp({
  data() {
    return {
      vip: {
        name: '',
        steamid: '',
        code: '',
        expire: null
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

      if (this.directVip) {
        let expireDate = new Date();
        switch (this.expireOption) {
          case '1D':
            expireDate.setDate(expireDate.getDate() + 1);
            break;
          case '1W':
            expireDate.setDate(expireDate.getDate() + 7);
            break;
          case '1M':
            expireDate.setMonth(expireDate.getMonth() + 1);
            break;
          case 'custom':
            expireDate = new Date(this.vip.expire);
            break;
        }
        formData.append('expire', this.formatDateTime(expireDate));
        formData.append('admin_group', 'vip');
        formData.append('used', '1');
      } else {
        formData.append('expire', '');
        formData.append('admin_group', '');
        formData.append('used', '0');
      }

      fetch('process_vip.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        console.log("Server response:", data);
        if (data.success) {
          alert('VIP added successfully!');
          this.resetVipForm();
        } else {
          alert('Error adding VIP: ' + data.message);
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
    },
    resetVipForm() {
      this.vip.name = '';
      this.vip.steamid = '';
      this.vip.code = '';
      this.directVip = false;
      this.expireOption = '1D';
      this.vip.expire = null;
    },
    setExpireDate() {
        const now = new Date();
        switch (this.expireOption) {
          case '1D':
            now.setDate(now.getDate() + 1);
            break;
          case '1W':
            now.setDate(now.getDate() + 7);
            break;
          case '1M':
            now.setMonth(now.getMonth() + 1);
            break;
          case 'custom':
            return;
        }
        if (this.expireOption !== 'custom') {
          this.vip.expire = this.formatDateTime(now);
        }
      },
     formatDateTime(date) {
      return date.toISOString().substring(0, 16);
    }
  }
}).mount('#app');
</script>