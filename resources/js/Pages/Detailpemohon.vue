<template>
  <Head title="Badge Form" />
  <MainLayout title="Data Visitor">
      <div>
          <el-form ref="formRef" :model="form" label-width="200px" label-position="top" require-asterisk-position="right" autocomplete="off">
              <!-- Email field -->
              <el-form-item :error="getFormError('email')" prop="email" label="Email" :required="true">
                    <el-input v-model="form.email" autocomplete="one-time-code" autocorrect="off" spellcheck="false" class="!w-full" />
                </el-form-item>

                <!-- Nama field -->
                <el-form-item :error="getFormError('nama')" prop="nama" label="Nama Tamu / Guest Name" :required="true">
                    <el-input v-model="form.nama" autocomplete="one-time-code" autocorrect="off" spellcheck="false" class="!w-full" />
                </el-form-item>

                <!-- Instansi field -->
                <el-form-item :error="getFormError('instansi')" prop="instansi" label="Instansi / Agency Name" :required="true">
                    <el-input v-model="form.instansi" autocomplete="one-time-code" autocorrect="off" spellcheck="false" class="!w-full" />
                </el-form-item>

                <!-- Handphone field -->
                <el-form-item :error="getFormError('handphone')" prop="handphone" label="No. Handphone / Phone Number" :required="true">
                    <el-input v-model="form.handphone" maxlength="15" placeholder="+62" autocomplete="one-time-code" autocorrect="off" spellcheck="false" class="!w-full" />
                </el-form-item>

                <!-- Keperluan field -->
                <el-form-item :error="getFormError('keperluan')" prop="keperluan" label="Keperluan Kunjungan / Visiting Requirements" :required="true">
                    <el-select v-model="form.keperluan" placeholder="Select" class="!w-full">
                        <el-option v-for="item in keperluanOptions" :key="item.value" :label="item.label" :value="item.value" />
                        <template #footer>
                            <el-button v-if="!isAddingKeperluan" text bg size="small" @click="onAddKeperluanOption">
                                Keperluan lain:
                            </el-button>
                            <template v-else>
                                <el-input v-model="keperluanOptionName" class="option-input" placeholder="input option name" size="small" />
                                <el-button type="primary" size="small" @click="onConfirmKeperluanOption">Confirm</el-button>
                                <el-button size="small" @click="clearKeperluanOption">Cancel</el-button>
                            </template>
                        </template>
                    </el-select>
                </el-form-item>

                <!-- Tujuan field -->
                <el-form-item :error="getFormError('tujuan')" prop="tujuan" label="Tujuan berkunjung / Purpose of Visiting" :required="true">
                    <el-select v-model="form.tujuan" placeholder="Select" class="!w-full">
                        <el-option v-for="item in tujuanOptions" :key="item.value" :label="item.label" :value="item.value" />
                        <template #footer>
                            <el-button v-if="!isAddingTujuan" text bg size="small" @click="onAddTujuanOption">
                                Tujuan lain:
                            </el-button>
                            <template v-else>
                                <el-input v-model="tujuanOptionName" class="option-input" placeholder="input option name" size="small" />
                                <el-button type="primary" size="small" @click="onConfirmTujuanOption">Confirm</el-button>
                                <el-button size="small" @click="clearTujuanOption">Cancel</el-button>
                            </template>
                        </template>
                    </el-select>
                </el-form-item>

                <!-- Durasi field -->
                <el-form-item :error="getFormError('durasi')" prop="durasi" label="Lama Kunjungan / Length of Visit" :required="true">
                    <el-select v-model="form.durasi" placeholder="Pilih Durasi" class="!w-full">
                      <el-option label="1 Hari" value="1 Day" />
                      <el-option label="2 Hari" value="2 Days" />
                      <el-option label="3 Hari" value="3 Days" />
                      <el-option label="4 Hari" value="4 Days" />
                      <el-option label="5 Hari" value="5 Days" />
                      <el-option label="6 Hari" value="6 Days" />
                      <el-option label="7 Hari" value="8 Days" />
                    </el-select>
                </el-form-item>

                <!-- Tanggal field -->
                <el-form-item :error="getFormError('tanggal')" prop="tanggal" label="Tanggal Kunjungan / Date of Visit" :required="true">
                    <el-date-picker v-model="form.tanggal" type="date" value-format="YYYY-MM-DD" placeholder="Pick a date" class="!w-full" />
                </el-form-item>

                <!-- Jumlah Pemohon field -->
                <el-form-item :error="getFormError('jpemohon')" prop="jpemohon" label="Jumlah Pemohon" :required="true">
                    <el-input v-model="form.jpemohon" autocomplete="one-time-code" autocorrect="off" spellcheck="false" class="!w-full" />
                </el-form-item>

              <hr class="my-4" />

              <!-- Identities section -->
              
              <div v-for="(identity, index) in form.identities" :key="index" class="space-y-4">
                  <el-card class="box-card mb-10">
                      <el-form-item :error="getFormError(`identities.${index}.name`)" prop="identities.name" label="Nama Identitas" :required="true">
                          <el-input v-model="identity.name" placeholder="Nama" required />
                      </el-form-item>
                      <el-form-item :error="getFormError(`identities.${index}.phone`)" prop="identities.phone" label="Nomor HP Identitas" :required="true">
                          <el-input v-model="identity.phone" maxlength="15" placeholder="+62" required />
                      </el-form-item>
                      <!-- <el-card class="mt-4 mb-4"> -->
                          <template #header>
                            <div slot="header" class="clearfix">
                  <span>Identitas Visitor</span>
              </div>
                          </template>
                          <el-form-item>
                              <div v-for="(file, fileIndex) in identity.media" :key="fileIndex" class="file-preview">
                                  <!-- <div class="file-name">{{ file.name }}</div> Nama file -->
                                  <el-image
                                      v-if="isImage(file.url)"
                                      style="width: 200px; height: 200px"
                                      :src="file.url"
                                      :zoom-rate="1.2"
                                      :max-scale="7"
                                      :min-scale="0.2"
                                      :preview-src-list="[file.url]"
                                      fit="cover"
                                  />
                                  <div v-else class="pdf-preview" @click="viewPDF(file.url)">
                                      <span> <div class="file-name">{{ file.name }}</div> </span>
                                  </div>
                              </div>
                          </el-form-item>
                      </el-card>
                  <!-- </el-card> -->
              </div>

              <el-form-item label="Keterangan" :required="true">
                  <el-input
                      type="textarea"
                      v-model="form.keterangan"
                      placeholder="Berikan alasan terkait penolakan berkas"
                      :rows="4"
                  />
              </el-form-item>

              <!-- Submit button -->
              <el-button class="approve-button" type="primary" @click="submitForm">Approve</el-button>
              <el-button class="decline-button" type="primary" @click="submitForm('0')">Reject</el-button>

          </el-form>
      </div>

      <!-- PDF Modal -->
      <el-dialog v-model="pdfDialogVisible" width="80%" :visible.sync="pdfDialogVisible">
          <iframe v-if="pdfUrl" :src="pdfUrl" width="100%" height="600px"></iframe>
      </el-dialog>
  </MainLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { ElMessage } from 'element-plus';

const form = useForm({
  id: null,
  email: null,
  nama: null,
  instansi: null,
  handphone: null,
  keperluan: null,
  tujuan: null,
  durasi: null,
  tanggal: null,
  jpemohon: null,
  status: null,
  identities: [
      { name: '', phone: '', media_identitas: [] }
  ],
  keterangan: null,
});

const formRef = ref();
const formErrors = ref([]);
const pdfDialogVisible = ref(false);
const pdfUrl = ref('');
const page = usePage();
const Userrole = page.props.auth.user.roles[0].name;

const isImage = (url) => {
  return url.match(/\.(jpeg|jpg|gif|png)$/i);
};

const viewPDF = (url) => {
  pdfUrl.value = url;
  pdfDialogVisible.value = true;
};

const getFormError = (field) => {
  return formErrors.value[field] ? formErrors.value[field] : '';
};

const submitForm = async (status) => {
  formErrors.value = [];
  if (status === '0'){
    form.status = '0';
  }
  const badgeid = form.id;
  if (Userrole === 'AVP' && status !== '0')
  {
    form.status = '2';
  }
 else if (Userrole === 'VP' && status !== '0')
  {
    form.status = '3';
  }
  else if (Userrole === 'SVPoperasi' && status !== '0')
  {
    form.status = '4';
  }
  else if (Userrole === 'VPkeamanan' && status !== '0')
  {
    form.status = '5';
  }
  
  
  form.post(route('data.update', badgeid), {
      preserveScroll: true,
      onSuccess: (response) => {
          ElMessage({
              message: response.props.flash.message,
              type: 'success',
          });
      },
      onError: (errors) => {
          formErrors.value = errors;
          if ('message' in errors) {
              ElMessage({
                  message: errors.message,
                  type: 'error',
              });
          }
      }
  });
};


onMounted(() => {
  const editbadge = page.props.editbadge;
  const editimage = page.props.badgeimage;
  if (editbadge) {
      form.id = editbadge.tr_badgeform_id;
      form.email = editbadge.email;
      form.nama = editbadge.nama;
      form.instansi = editbadge.instansi;
      form.handphone = editbadge.handphone;
      form.keperluan = editbadge.keperluan;
      form.tujuan = editbadge.tujuan;
      form.durasi = editbadge.durasi;
      form.tanggal = editbadge.tanggal;
      form.jpemohon = editbadge.jpemohon;
      form.identities = editbadge.identities;
      form.status = editbadge.status;
  } else {
      console.error('laporan tidak ditemukan');
  }
});
</script>

<style scoped>
.approve-button {
  background-color: rgb(0, 255, 0);
  border-color: rgb(0, 255, 0);
  margin-right: 10px;
  margin-top: 10px;
}

.decline-button {
  background-color: red;
  border-color: red;
  margin-top: 10px;
}

.file-preview {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 20px; /* Tambahkan margin-top untuk memberikan jarak */
  margin-bottom: 5px;
}

.file-name {
  margin-bottom: 5px;
  /* font-weight: bold; */
  text-align: center;
}

.pdf-preview {
  cursor: pointer;
  background-color: #ffffff;
  padding: 10px;
  text-align: center;
  border-radius: 5px;
  color: #000;
  /* font-weight: bold; */
}

.pdf-preview:hover {
  background-color: #d9d9d9;
  font-weight: bold;
}
</style>
