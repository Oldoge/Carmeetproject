<script setup>
import { ref, onMounted } from 'vue'; // Added onMounted
import axios from 'axios';

const carshow = ref([]);

const fetchCarshow = async () => {
    try {
        const response = await axios.get('http://127.0.0.1:8000/api/car-shows'); // Changed to GET
        if (response.status === 200) {
            carshow.value = response.data;
        } else {
            console.error('Failed to fetch car show data:', response.statusText);
        }
    } catch (error) {
        console.error('Error fetching car show data:', error);
    }
};

const addcarshow = ref(false);
const toggleAddCarshow = () => {
    addcarshow.value = !addcarshow.value;
};

const newCarShow = ref({
  title: '',
  picture: '',
  organizer: '',
  event_date: '',
  event_date_start: '',
  event_date_end: '',
  location: '',
  description: ''
});

const submitCarShow = async () => {
  try {
    const response = await axios.post('http://127.0.0.1:8000/api/car-shows', newCarShow.value);
    if (response.status === 201) {
      carshow.value.push(response.data);
      toggleAddCarshow();
      newCarShow.value = {
        title: '',
        picture: '',
        organizer: '',
        event_date: '',
        event_date_start: '',
        event_date_end: '',
        location: '',
        description: ''
      };
    } else {
      console.error('Failed to add car show:', response.statusText);
    }
  } catch (error) {
    console.error('Error adding car show:', error);
    if (error.response) {
      console.error('Server response:', error.response.data);
    }
  }
};

const showEditPopup = ref(false);
const showDeletePopup = ref(false);
const editCarShowData = ref({});

const toggleEditPopup = () => {
  showEditPopup.value = !showEditPopup.value;
};

const toggleDeletePopup = () => {
  showDeletePopup.value = !showDeletePopup.value;
};

const editCarShow = (id) => {
  const carShow = carshow.value.find((show) => show.id === id);
  if (carShow) {
    editCarShowData.value = { ...carShow };
    toggleEditPopup();
  }
};

const submitEditCarShow = async () => {
  try {
    console.log('Submitting edit data:', editCarShowData.value); // Log the data being sent
    const response = await axios.put(`http://127.0.0.1:8000/api/car-shows/${editCarShowData.value.id}`, editCarShowData.value);
    if (response.status === 200) {
      const index = carshow.value.findIndex((show) => show.id === editCarShowData.value.id);
      if (index !== -1) {
        carshow.value[index] = response.data;
      }
      toggleEditPopup();
    } else {
      console.error('Failed to edit car show:', response.statusText);
    }
  } catch (error) {
    console.error('Error updating car show:', error);
    if (error.response) {
      console.error('Server response:', error.response.data); // Log server response
    }
  }
};

const deleteCarShowId = ref(null);

const deleteCarShow = (id) => {
  deleteCarShowId.value = id;
  toggleDeletePopup();
};

const confirmDeleteCarShow = async () => {
  try {
    const response = await axios.delete(`http://127.0.0.1:8000/api/car-shows/${deleteCarShowId.value}`);
    if (response.status === 200) {
      carshow.value = carshow.value.filter((show) => show.id !== deleteCarShowId.value);
      deleteCarShowId.value = null; // Reset the delete ID
      toggleDeletePopup();
    } else {
      console.error('Failed to delete car show:', response.statusText);
    }
  } catch (error) {
    console.error('Error deleting car show:', error);
    if (error.response) {
      console.error('Server response:', error.response.data);
    }
  }
};

// Fetch data when the component is mounted
onMounted(() => {
    fetchCarshow();
});
</script>

<template>
 <main>
    <div>
        <h1>This is the table</h1>
        <button @click="toggleAddCarshow">Add Car Show</button> <!-- Fixed v-model typo -->
        <table class="table">
            <thead>
                <tr class="thshit">
                    <th style="color: black;">Title</th>
                    <th>Picture</th>
                    <th>Organizer</th>
                    <th>Event Date</th>
                    <th>Event Start Date</th>
                    <th>Event End Date</th>
                    <th>Location</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="show in carshow" :key="show.id" class="thshit">
                    <td>{{ show.title }}</td>
                    <td>
                        <img v-if="show.picture" :src="show.picture" alt="Event Picture" style="max-width: 100px; max-height: 100px;">
                        <span v-else>No Picture</span>
                    </td>
                    <td>{{ show.organizer || 'N/A' }}</td>
                    <td>{{ show.event_date || 'N/A' }}</td>
                    <td>{{ show.event_date_start || 'N/A' }}</td>
                    <td>{{ show.event_date_end || 'N/A' }}</td>
                    <td>{{ show.location }}</td>
                    <td>{{ show.description || 'N/A' }}</td>
                    <td>
                        <div class="admin-actions">
                            <button @click="editCarShow(show.id)" class="btn edit">Edit</button>
                            <button @click="deleteCarShow(show.id)" class="btn delete">Delete</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div v-if="addcarshow" class="modal">
        <div class="modal-content">
            <span class="close" @click="toggleAddCarshow">&times;</span>
            <h2>Add New Car Show</h2>
            <form @submit.prevent="submitCarShow">
                <label for="title">Title:</label>
                <input type="text" id="title" v-model="newCarShow.title" required />

                <label for="picture">Picture URL:</label>
                <input type="text" id="picture" v-model="newCarShow.picture" />

                <label for="organizer">Organizer:</label>
                <input type="text" id="organizer" v-model="newCarShow.organizer" />

                <label for="event_date">Event Date:</label>
                <input type="date" id="event_date" v-model="newCarShow.event_date" />

                <label for="event_date_start">Event Start Date:</label>
                <input type="datetime-local" id="event_date_start" v-model="newCarShow.event_date_start" />

                <label for="event_date_end">Event End Date:</label>
                <input type="datetime-local" id="event_date_end" v-model="newCarShow.event_date_end" />

                <label for="location">Location:</label>
                <input type="text" id="location" v-model="newCarShow.location" />

                <label for="description">Description:</label>
                <textarea id="description" v-model="newCarShow.description"></textarea>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    <div v-if="showEditPopup" class="modal">
      <div class="modal-content">
        <span class="close" @click="toggleEditPopup">&times;</span>
        <h2>Edit Car Show</h2>
        <form @submit.prevent="submitEditCarShow">
          <label for="edit-title">Title:</label>
          <input type="text" id="edit-title" v-model="editCarShowData.title" required />

          <label for="edit-picture">Picture URL:</label>
          <input type="text" id="edit-picture" v-model="editCarShowData.picture" />

          <label for="edit-organizer">Organizer:</label>
          <input type="text" id="edit-organizer" v-model="editCarShowData.organizer" />

          <label for="edit-event_date">Event Date:</label>
          <input type="date" id="edit-event_date" v-model="editCarShowData.event_date" />

          <label for="edit-event_date_start">Event Start Date:</label>
          <input type="datetime-local" id="edit-event_date_start" v-model="editCarShowData.event_date_start" />

          <label for="edit-event_date_end">Event End Date:</label>
          <input type="datetime-local" id="edit-event_date_end" v-model="editCarShowData.event_date_end" />

          <label for="edit-location">Location:</label>
          <input type="text" id="edit-location" v-model="editCarShowData.location" />

          <label for="edit-description">Description:</label>
          <textarea id="edit-description" v-model="editCarShowData.description"></textarea>

          <button type="submit">Save Changes</button>
        </form>
      </div>
    </div>

    <div v-if="showDeletePopup" class="modal">
      <div class="modal-content">
        <span class="close" @click="toggleDeletePopup">&times;</span>
        <h2>Confirm Deletion</h2>
        <p>Are you sure you want to delete this car show?</p>
        <button @click="confirmDeleteCarShow" class="btn delete">Yes, Delete</button>
        <button @click="toggleDeletePopup" class="btn cancel">Cancel</button>
      </div>
    </div>
 </main>
</template>

<style scoped>
.table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 18px;
    text-align: left;
}

.table th, .table td {
    border: 1px solid #ddd;
    padding: 8px;
}

.table th {
    background-color: #f4f4f4;
    color: black; /* Changed color to black */
    font-weight: bold;
}

.thshit td{
    color: black;
}
.table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.table tr:hover {
    background-color: #f1f1f1;
}

.modal {
  display: flex;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.8); /* Darker background */
}

.modal-content {
  background-color: #333; /* Darker modal background */
  color: #fff; /* White text */
  margin: auto;
  padding: 20px;
  border: 1px solid #444; /* Darker border */
  width: 50%;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add shadow */
}

.close {
  color: #fff; /* White close button */
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

.close:hover,
.close:focus {
  color: #f00; /* Red on hover */
  text-decoration: none;
}

label {
  color: #ddd; /* Light gray labels */
}

input, textarea, button {
  background-color: #444; /* Darker input background */
  color: #fff; /* White text */
  border: 1px solid #555; /* Darker border */
  border-radius: 5px;
  padding: 10px;
  margin-bottom: 10px;
  width: 100%;
}

button {
  background-color: #555; /* Button background */
  cursor: pointer;
}

button:hover {
  background-color: #666; /* Darker button on hover */
}
</style>