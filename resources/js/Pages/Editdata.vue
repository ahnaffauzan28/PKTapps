<template>
  <Head title="Badge Form" />
  <MainLayout title="Edit Data">
      <div  :key="form.id">
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

              <el-form-item :error="getFormError('ms_komparteman_id')" prop="ms_komparteman_id" label="Kompartemen / Compartment" :required="true">
    <el-select v-model="form.ms_komparteman_id" placeholder="Select" class="!w-full">
      <el-option
        v-for="kompartemen in kompartemens"
        :key="kompartemen.ms_komparteman_id"
        :label="kompartemen.nama_kompartemen"
        :value="kompartemen.ms_komparteman_id"
      />
    </el-select>
  </el-form-item>
  <!-- <div>Kompartemen Terpilih: {{ selectedKompartemen ? selectedKompartemen.nama_kompartemen : '' }}</div> -->


  <!-- Departemen field -->
  <el-form-item :error="getFormError('ms_departeman_id')" prop="ms_departeman_id" label="Departemen / Department" :required="true">
    <el-select v-model="form.ms_departeman_id" placeholder="Select" class="!w-full">
      <el-option
        v-for="departemen in departemens.filter(departemen => departemen.ms_komparteman_id === form.ms_komparteman_id)"
        :key="departemen.ms_departeman_id"
        :label="departemen.nama_departemen"
        :value="departemen.ms_departeman_id"
      />
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
              <el-card class="box-card">
                  <div slot="header" class="clearfix">
                      <span>Identitas Tambahan</span>
                  </div>
                  <el-form-item label="Masukkan identitas sesuai jumlah pemohon:" label-style="font-weight: bold;"></el-form-item>

                  <div v-for="(identity, index) in form.identities" :key="index" class="space-y-4">
                      <el-form-item :error="getFormError(`identities.${index}.name`)" prop="`identities.${index}.name`" label="Nama Identitas" :required="true">
                          <el-input v-model="identity.name" placeholder="Nama" required />
                      </el-form-item>
                      <el-form-item :error="getFormError(`identities.${index}.phone`)" prop="`identities.${index}.phone" label="Nomor HP Identitas" :required="true">
                          <el-input v-model="identity.phone" maxlength="15" placeholder="+62" required />
                      </el-form-item>
                      <el-form-item :error="getFormError('media_identitas')" prop="media_identitas" label="Masukkan (KTP / Passport) dan (Surat Pengajuan / Submission letter)" :required="true">
                          <el-upload
                              drag
                              v-model:file-list="identity.media_identitas"
                              class="!w-full"
                              :auto-upload="false"
                              :limit="3"
                              accept="image/jpeg,image/png,application/pdf"
                               :on-preview="handlePreview"
                          >
                              <el-icon class="el-icon--upload"><upload-filled /></el-icon>
                              <div class="el-upload__text">
                                  Drop file here or <em>click to upload</em>
                              </div>
                              <template #tip>
                                  <div class="el-upload__tip">
                                      jpg/png/pdf files with a size less than 5MB
                                  </div>
                              </template>
                          </el-upload>
                      </el-form-item>
                      <el-button type="danger" @click="removeIdentity(index)">Hapus Identitas</el-button>
                  </div>
                 
              </el-card>

              <!-- Submit button -->
              <div class="button-container">
                  <el-button type="primary" @click="submitForm('0')">Update</el-button>
                  <el-button type="primary" @click="submitForm('1')">Submit</el-button>
              </div>
            
          </el-form>
      </div>
  </MainLayout>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { ElMessage } from 'element-plus';
import { UploadFilled } from '@element-plus/icons-vue'

const form = useForm({
id: null,
email: null,
nama: null,
instansi: null,
handphone: null,
keperluan: null,
tujuan: null,
ms_komparteman_id: null, 
ms_departeman_id: null,
durasi: null,
tanggal: null,
jpemohon: null,
//   media_identitas: [],
identities: [
  { name: '', phone: '',   media_identitas: []}
],
status: null,
keterangan: null,
});


const page = usePage();
const formRef = ref();
const formErrors = ref([]);
const kompartemens = page.props.kompartemenOptions;
const departemens = page.props.departemenOptions;




const getFormError = (field) => {
  return formErrors.value[field] ? formErrors.value[field] : '';
};

const removeIdentity = (index) => {
form.identities.splice(index, 1);
};



const submitForm = async (status) => {
form.status = status;
formErrors.value = [];
const badgeid = form.id;
form.post(route('data.update', badgeid), {
  preserveScroll: true,
  onSuccess: (response) => {
    ElMessage({
      message: response.props.flash.message,
      type: 'success',
    });
   
    
  },
  onError: (errors) => {
    console.log(errors);  
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

const isAddingKeperluan = ref(false);
const keperluanOptionName = ref('');
const keperluanOptions = ref([
{ value: 'Site Visit / Survey', label: 'Site Visit / Survey' },
{ value: 'Rapat / Kunjungan / meeting', label: 'Rapat / Kunjungan / meeting' }
]);

const onAddKeperluanOption = () => {
isAddingKeperluan.value = true;
};

const onConfirmKeperluanOption = () => {
if (keperluanOptionName.value) {
  keperluanOptions.value.push({
    label: keperluanOptionName.value,
    value: keperluanOptionName.value,
  });
  clearKeperluanOption();
}
};

const clearKeperluanOption = () => {
keperluanOptionName.value = '';
isAddingKeperluan.value = false;
};

const isAddingTujuan = ref(false);
const tujuanOptionName = ref('');
const tujuanOptions = ref([
{ value: 'Zona 1 (Pemeliharaan, Lab, Istek 1&2, Bengkel, Pabrik 1-7, PPE, Dermaga)', label: 'Zona 1 (Pemeliharaan, Lab, Istek 1&2, Bengkel, Pabrik 1-7, PPE, Dermaga)' },
{ value: 'Zona 2 (JPP, Shiping, Plant Off Site, Pertagas, KIE, Dermaga, K3)', label: 'Zona 2 (JPP, Shiping, Plant Off Site, Pertagas, KIE, Dermaga, K3)' },
{ value: 'Kantor Pusat (Humas, Keuangan, TJSL, PSDMO)', label: 'Kantor Pusat (Humas, Keuangan, TJSL, PSDMO)' },
{ value: 'Kaltim Daya Mandiri. PT', label: 'Kaltim Daya Mandiri. PT' },
{ value: 'Kaltim Methanol Industri. PT', label: 'Kaltim Methanol Industri. PT' },
{ value: 'Kaltim Parna Industri. PT', label: 'Kaltim Parna Industri. PT' }
]);

const onAddTujuanOption = () => {
isAddingTujuan.value = true;
};

const onConfirmTujuanOption = () => {
if (tujuanOptionName.value) {
  tujuanOptions.value.push({
    label: tujuanOptionName.value,
    value: tujuanOptionName.value,
  });
  clearTujuanOption();
}
};

const clearTujuanOption = () => {
tujuanOptionName.value = '';
isAddingTujuan.value = false;
};



onMounted(() => {
  const editbadge = page.props.editbadge;
  
  
  if(editbadge) {
      form.id = editbadge.tr_badgeform_id;
      form.email = editbadge.email;
      form.nama = editbadge.nama;
      form.instansi = editbadge.instansi;
      form.handphone = editbadge.handphone;
      form.keperluan = editbadge.keperluan;
      form.tujuan = editbadge.tujuan;
      form.ms_komparteman_id = editbadge.ms_komparteman_id;
      form.ms_departeman_id = editbadge.ms_departeman_id;
      form.durasi = editbadge.durasi;
      form.tanggal = editbadge.tanggal;
      form.jpemohon = editbadge.jpemohon;
      form.identities = editbadge.identities.map((item, index) => {
          return {
              id: item.tr_tambahidentitum_id,
              name: item.name,
              phone: item.phone,
              media_identitas: item.media,
          }
      });
      console.log(form.identities);
  } else {
      console.error('laporan tidak ditemukan');
  }
});
  

</script>

<style lang="scss" scoped>
.option-input {
width: 100%;
margin-bottom: 8px;
}

.button-container {
display: flex;
  justify-content: flex-start; /* Align buttons to the left */
  gap: 10px; /* Space between buttons */
  margin-top: 30px;
  margin-bottom: 0;
}
</style> 