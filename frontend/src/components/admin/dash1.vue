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
                </tr>
            </tbody>
        </table>
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
</style>