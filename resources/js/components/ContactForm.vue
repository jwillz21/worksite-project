<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
              <form v-on:submit.prevent="onClick">
                <div class="form-group col-4 pl-0">
                  <label for="inputName col-4 pl-0">Name</label>
                  <input v-model="name" type="name" class="form-control" id="inputName" placeholder="Enter Name">
                  <small id="name-error" class="form-text text-muted">{{nameError}}</small>
                </div>
                <div class="form-group col-4 pl-0">
                  <label for="inputEmail">Email address</label>
                  <input v-model="email" class="form-control" id="inputEmail" placeholder="Enter Email">
                  <small id="email-error" class="form-text text-muted">{{emailError}}</small>
                </div>
                <div class="form-group col-4 pl-0">
                  <label for="inputPhone">Phone</label>
                  <input v-model="phone" type="phone" class="form-control" id="inputPhone" placeholder="Enter Phone">
                  <small id="phone-error" class="form-text text-muted">{{phoneError}}</small>
                </div>
                <div class="form-group col-8 pl-0">
                  <label for="inputMessage">Message</label>
                  <textarea v-model="message" type="text" class="form-control" id="inputMessage" placeholder="Enter Message"></textarea>
                  <small id="message-error" class="form-text text-muted">{{messageError}}</small>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <!-- <small id="submit-confirm" class="form-text text-muted"></small> -->
              </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
          onClick(){
          const self = this;
           var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                let errors = JSON.parse(this.responseText);
                self.nameError = errors["nameError"];
                self.phoneError = errors["phoneError"];
                self.emailError = errors["emailError"];
                self.messageError = errors["messageError"];
              }
            };
            xhttp.open("POST", "/api/inquiry", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            let query = "name=" + this.name +
                        "&phone=" + this.phone +
                        "&email=" + this.email +
                        "&message=" + this.message;
            xhttp.send(query);
          },
        },
        data(){
          return{
            name: null,
            email: null,
            phone: null,
            message: null,
            nameError: null,
            phoneError: null,
            emailError: null,
            messageError: null
          }
        }
    }
</script>
