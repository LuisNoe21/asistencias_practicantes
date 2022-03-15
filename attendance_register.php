<?php
?>
<?php
include_once "header.php";
include_once "nav.php";
?>
<div class="row" id="app">
    <div class="col-12">
        <h1 class="text-center">Asistencia</h1>
    </div>
    <div class="col-12">
        <div class="form-inline mb-2">
            <label for="date">Fecha: &nbsp;</label>
            <input @change="refreshPracticantesList" v-model="date" name="date" id="date" type="date" class="form-control">

            <button @click="save" class="btn btn-success ml-2">Guardar</button>
        </div>
    </div>
    <div class="col-12">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            Practicante
                        </th>
                        <th>
                            Estado
                        </th>
                        <th>
                            Hora Entrada
                        </th>
                        <th>
                            Hora Salida
                        </th>
                        <th>
                            Permiso
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="practicante in practicantes">
                        <td>{{practicante.name}}</td>
                        <td>
                            <select v-model="practicante.status" class="form-control">
                                <option disabled value="unset">--Selecccionar--</option>
                                <option value="presence">Asistio</option>
                                <option value="absence">No Asistio</option>
                            </select>
                        </td>
                        <td>
                            <template v-if="practicante.status === 'presence'">
                                <input type="time" class="form-control" v-model="practicante.hentrada">
                            </template>
                        </td>
                        <td>
                            <template v-if="practicante.status === 'presence'">
                                <input type="time" class="form-control" v-model="practicante.hsalida">
                            </template>
                        </td>
                        <template v-if="practicante.status === 'absence'">
                            <td col-span="2">
                                <label>
                                    <input type="checkbox" class="form-control" v-model="practicante.permiso">
                                    Permiso
                                </label>
                            </td>
                        </template>
                        <template v-else>
                            <td></td>
                        </template>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="js/vue.min.js"></script>
<script src="js/vue-toasted.min.js"></script>
<script>
    Vue.use(Toasted);
    const UNSET_STATUS = "unset";
    new Vue({
        el: "#app",
        data: () => ({
            practicantes: [],
            date: "",
        }),
        async mounted() {
            this.date = this.getTodaysDate();
            await this.refreshPracticantesList();
        },
        methods: {
            getTodaysDate() {
                const date = new Date();
                const month = date.getMonth() + 1;
                const day = date.getDate();
                return `${date.getFullYear()}-${(month < 10 ? '0' : '').concat(month)}-${(day < 10 ? '0' : '').concat(day)}`;
            },
            async save() {
                // We only need id and status, nothing more
                let practicantesMapped = this.practicantes.map(practicante => {
                    console.log(practicante.permiso)
                    return {
                        id: practicante.id,
                        status: practicante.status,
                        hentrada: practicante.hentrada,
                        hsalida: practicante.hsalida,
                        permiso: practicante.permiso,
                    }
                });
                // And we need only where status is set
                practicantesMapped = practicantesMapped.filter(practicante => practicante.status != UNSET_STATUS);
                const payload = {
                    date: this.date,
                    practicantes: practicantesMapped,
                };
                const response = await fetch("./save_attendance_data.php", {
                    method: "POST",
                    body: JSON.stringify(payload),
                });
                this.$toasted.show("Saved", {
                    position: "top-left",
                    duration: 1000,
                });
            },
            async refreshPracticantesList() {
                // Get all practicantes
                let response = await fetch("./get_practicantes_ajax.php");
                let practicantes = await response.json();
                // Set default status: unset
                let practicanteDictionary = {};
                practicante = practicantes.map((practicante, index) => {
                    practicanteDictionary[practicante.id] = index;
                    return {
                        id: practicante.id,
                        name: practicante.name,
                        status: UNSET_STATUS,
                    }
                });
                // Get attendance data, if any
                response = await fetch(`./get_attendance_data_ajax.php?date=${this.date}`);
                let attendanceData = await response.json();
                // Refresh attendance data in each practicante, if any
                attendanceData.forEach(attendanceDetail => {
                    let practicanteId = attendanceDetail.practicante_id;
                    if (practicanteId in practicanteDictionary) {
                        let index = practicanteDictionary[practicanteId];
                        practicantes[index].status = attendanceDetail.status;
                        practicantes[index].hentrada = attendanceDetail.hentrada;
                        practicantes[index].hsalida = attendanceDetail.hsalida;
                        practicantes[index].permiso = attendanceDetail.permiso;
                    }
                });
                // Let Vue do its magic ;)
                this.practicantes = practicantes;
            }
        },
    });
</script>
<?php
include_once "footer.php";
