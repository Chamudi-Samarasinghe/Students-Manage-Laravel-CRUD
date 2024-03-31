<template>
    <NavBar />
    
    <div class="container mx-auto ">
        <div class="d-flex justify-content-center mt-8">
            <div class="w-2/3 enroll-form-container" >
                <div class="card enroll-form">
                    <div class="card-body">
                        <h4 class="card-title font-weight-bold text-lg mb-4" style="text-align: center;">Enroll Student</h4>

                        <form @submit.prevent="studentStore" class="form">
                            <div class="mb-3">
                                <label for="input1" class="form-label">Student Name</label>
                                <input type="text" class="form-control" name="name" v-model="student_data.name" id="input1"
                                    placeholder="Name">
                            </div>
                            <div class="mb-3">
                                <label for="input2" class="form-label">Student Age</label>
                                <input type="text" class="form-control" name="age" v-model="student_data.age" id="input2"
                                    placeholder="Age">
                            </div>
                            <div class="mb-3">
                                <label for="input3" class="form-label">Image</label>
                                <input type="file" class="form-control" name="image" id="input3" @change="handleImageUpload">
                            </div>
                            <button type="submit" class="btn btn-warning mt-3" style="background-color: black; color: white; border-radius: 30px; border-color: gray;" >Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 ">
            <div class="student-list-container">
            <h1 class="font-weight-bold text-2xl" >Student List</h1>
  
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>SR.NO</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(student, index) in student_list" :key="student.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ student.name }}</td>
                                <td>{{ student.age }}</td>
                                <td>
                                    <span v-if="student.status === 1" class="badge bg-success">Active</span>
                                    <span v-if="student.status === 0" class="badge bg-warning">Inactive</span>
                                </td>
                                <td>
                                    <div class="image-box" v-if="student.image">
                                        <img :src="student.image" alt="Student Image" />
                                    </div>
                                </td>
                                
                                <td>
                                    
                                    <button @click.prevent="editStudent(student.id)" class="btn btn-success mr-2" style="background-color: #9F2B68; border-color: black;">Edit</button>
                                    <button @click.prevent="changeStudentStatus(student.id)" class="btn btn-primary mr-2" style="background-color: #BF40BF; border-color: black;">Status</button>
                                    <button @click.prevent="deleteStudent(student.id)" class="btn btn-danger mr-2" style="background-color: #800080; border-color: black">Delete</button>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


 
<div class="modal" id="studentEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" >Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form @submit.prevent="studentUpdate" class="form">
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="name" v-model="student_update_data.name" placeholder="Name">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="age" v-model="student_update_data.age" placeholder="Age">
                    </div>
                    <div class="mb-3">
                        <label for="input4" class="form-label">Update Image</label>
                        <input type="file" class="form-control" name="image" id="input4" @change="handleUpdateImageUpload">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary text-dark" data-bs-dismiss="modal" style="background-color: gray; border-radius: 10px; border-color: black;">Close</button>
                    <button type="submit" class="btn btn-primary text-dark" style="background-color: gray; border-radius: 10px; border-color: black; border">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

    </div>
    
</template>

<script>
import axios from 'axios';
import NavBar from '@/Components/Main/NavBar.vue';
//import ResponsiveNavLink from '../../../../vendor/laravel/breeze/stubs/inertia-react-ts/resources/js/Components/ResponsiveNavLink';

export default {
    data() {
        return {
            student_list: [],
            student_data: {},
            student_update_data: {},
        };
    },
    components: {
        NavBar,
    },
    beforeMount() {
        this.getStudents();
    },
    methods: {
        async getStudents() {
            const response = await axios.get(route('student.list'));
            this.student_list = response.data;
        },
        async studentStore() {
            await axios.post(route('student.store'), this.student_data);
            this.getStudents();
            this.student_data = {};
        },
        async deleteStudent(id) {
            await axios.delete(route('student.delete', id));
            this.getStudents();
        },
        async changeStudentStatus(id) {
            await axios.get(route('student.status', id));
            this.getStudents();
        },



        async editStudent(id) {
    console.log('Attempting to edit student with ID:', id);

    const response = await axios.get(route('student.get', id));
    console.log('Response from API:', response.data);

    this.student_update_data = response.data;
    console.log('Updated student data:', this.student_update_data);

    $('#studentEdit').modal('show');
    console.log('Modal shown for editing student');
},


        async studentUpdate() {
            await axios.post(route('student.update', this.student_update_data.id), this.student_update_data);
            this.getStudents();
            this.student_update_data = {};
            $('#studentEdit').modal('hide');
        },
        handleImageUpload(event) {
            const file = event.target.files[0];
            this.student_data.image = URL.createObjectURL(file);
        },
        handleUpdateImageUpload(event) {
        const file = event.target.files[0];
        this.student_update_data.image = URL.createObjectURL(file);
    },
    },
};
</script>

<style>
body {
  background-color: rgb(107, 93, 136);
  font-family: Arial, sans-serif;
  /* min-height: 100vh; 
  padding: 20px; */
}

h1{
  text-align: center;

}

.enroll-form-container {
    background-color: black;
    padding: 4px; 
    border-radius: 8px; 
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
    margin-bottom: 20px; 
}

.enroll-form{
  
    background-image: linear-gradient(to right, rgb(198, 170, 250) , rgb(221, 221, 221));
}

    .image-box {
        width: 70px;
        height: 60px;
        overflow: hidden;
    }

    .image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Styles for student list */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    
    
    
}

.table th,
.table td {
    padding: 10px;
    border: 1px solid #dee2e6;
    
}

.table th {
    background-color: #6c757d;
    color: #fff;
    text-align: left;
    
}

.table tbody tr:nth-child(even) {
    background-color: #f0f1f2;
}

.table tbody tr:hover {
    background-color: #e9ecef;
}

.badge {
    padding: 5px 10px;
    border-radius: 3px;
    background-image: linear-gradient(to right, rgb(127, 41, 239) , rgb(127, 41, 239));
    
}

.badge.bg-success {
    background-color: #28a745;
    color: #fff;
  
}

.badge.bg-warning {
    background-color: #ffc107;
    color: #212529;
}

.badge.bg-danger {
    background-color: #dc3545;
    color: #fff;
}

.student-list-container {
    /* background-color: gray; */
    background-image: linear-gradient(to right, rgb(198, 170, 250) , rgb(255, 255, 255));
    padding: 10px;
    margin-bottom: 40px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/*  edit student  form */
.modal-dialog {
    max-width: 500px; 
}

.modal-title {
    font-size: 1.5rem;
    font-weight: bold;
       
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    padding: 20px;
    justify-content: space-between;
}

.form-control {
    margin-bottom: 15px;
}

.form-label {
    font-weight: bold;
}


</style>