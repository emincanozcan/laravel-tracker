<template>
  <container>
    <modal v-if="showModal" @close="showModal = false">
      <span v-html="modalBody"></span>
    </modal>
    <div class="bg-white rounded-md shadow-md px-4 py-4">
      <Title text="Last Activities" />
      <div class="my-4 flex items-end justify-between">
        <div class="flex flex-wrap justify-between">
          <activity-filter text="Trackable Type" class="ml-0">
            <Select v-model="filters.trackable_type">
              <option value="">All</option>
              <option :value="v" v-for="v in filterOptions.types" :key="v">
                {{ v }}
              </option>
            </Select>
          </activity-filter>
          <activity-filter text="Trackable ID">
            <Input type="text" v-model="filters.trackable_id" class="w-24" />
          </activity-filter>
          <activity-filter text="Action">
            <Select v-model="filters.action">
              <option value="">All</option>
              <option :value="v" v-for="v in filterOptions.action" :key="v">
                {{ v }}
              </option>
            </Select>
          </activity-filter>
          <activity-filter text="Ip Address">
            <Input type="text" v-model="filters.ip_address" class="w-32" />
          </activity-filter>
          <activity-filter text="Request ID">
            <Input type="text" v-model="filters.request_id" class="w-32" />
          </activity-filter>
        </div>
        <div>
          <Button class="w-20 py-2" @click.native="filter">Filter</Button>
          <Button class="w-20 py-2 ml-2" @click.native="clearFilters">
            Clear
          </Button>
        </div>
      </div>
      <loader v-if="loading"> Last Activities Are Loading...</loader>
      <div v-else>
        <table
          class="min-w-full table-auto rounded-md shadow-md overflow-hidden"
        >
          <thead class="justify-between">
            <tr class="bg-gray-700">
              <activity-th text="Trackable" />
              <activity-th text="Request ID" />
              <activity-th text="Action" />
              <activity-th text="Ip Address" />
              <activity-th text="Message" />
              <activity-th text="Date" />
              <activity-th text="Additional Data" />
            </tr>
          </thead>
          <tbody>
            <tr
              class="border-b-2 border-gray-200"
              v-for="data in tableData"
              :key="data.id"
            >
              <activity-td
                @click.native="
                  setFilterFromData(['trackable_id', 'trackable_type'], data)
                "
                class="text-blue-700 cursor-pointer flex items-center justify-between"
              >
                <span>{{ data.trackable_type }}</span>
                <span>{{ data.trackable_id }}</span>
              </activity-td>
              <activity-td
                @click.native="setFilterFromData(['request_id'], data)"
                class="text-blue-700 cursor-pointer"
              >
                {{ data.request_id }}
              </activity-td>
              <activity-td
                @click.native="setFilterFromData(['action'], data)"
                class="text-blue-700 cursor-pointer"
              >
                {{ data.action }}
              </activity-td>
              <activity-td
                @click.native="setFilterFromData(['ip_address'], data)"
                class="text-blue-700 cursor-pointer"
              >
                {{ data.ip_address }}
              </activity-td>
              <activity-td :title="data.message">
                {{ data.message.substring(0, 24) }}
              </activity-td>
              <activity-td>{{ data.created_at }}</activity-td>
              <activity-td>
                <button
                  class="text-blue-700 cursor-pointer font-medium"
                  v-if="Object.values(data.additional_data).length > 0"
                  @click="openModal(data.additional_data)"
                >
                  Show Additional Details
                </button>
                <span v-else> No Additional Details </span>
              </activity-td>
            </tr>
          </tbody>
        </table>
        <div class="mt-4 flex justify-end">
          <Button
            v-for="link in paginationLinks"
            :key="link.label"
            @click.native="fetch(link.url)"
            :disabled="(link.active || link.url == null) && !showModal"
          >
            <span v-html="link.label" class="text-sm"></span>
          </Button>
        </div>
      </div>
    </div>
  </container>
</template>

<script>
import queryString from "query-string";
import Container from "../components/Container";
import axios from "axios";
import Select from "../components/Select";
import Loader from "../components/Loader";
import Input from "../components/Input.vue";
import ActivityTh from "../components/ActivityTh.vue";
import ActivityTd from "../components/ActivityTd.vue";
import Button from "../components/Button.vue";
import ActivityFilter from "../components/ActivityFilter.vue";
import Title from "../components/Title.vue";
import Modal from "../components/Modal.vue";

export default {
  components: {
    Container,
    Select,
    Loader,
    Input,
    ActivityTh,
    ActivityTd,
    Button,
    ActivityFilter,
    Title,
    Modal,
  },
  name: "LastActivities",
  data() {
    return {
      showModal: false,
      modalBody: "",
      loading: true,
      tableData: [],
      paginationLinks: {},
      filtersInitialState: {
        trackable_type: "",
        trackable_id: "",
        ip_address: "",
        request_id: "",
        action: "",
      },
      filterOptions: {},
      filters: {},
    };
  },
  methods: {
    openModal(data) {
      this.showModal = true;
      this.modalBody = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
    },
    clearFilters() {
      this.filters = Object.assign({}, this.filtersInitialState);
      this.fetch();
    },
    setFilterFromData(keys, data) {
      this.filters = Object.assign({}, this.filtersInitialState);
      keys.forEach((key) => (this.filters[key] = data[key]));
      this.fetch();
    },
    filter() {
      this.fetch(window.tracker.lastActivities);
    },
    async fetchFilters() {
      const response = await axios.get(window.tracker.filters);
      this.filterOptions = response.data;
    },
    async fetch(url) {
      this.loading = true;
      if (typeof url == "undefined") url = window.tracker.lastActivities;
      const urlWithFilters = queryString.stringifyUrl({
        url: url,
        query: this.filters,
      });
      const response = await axios.get(urlWithFilters);
      const data = response.data;

      if (data.links) this.paginationLinks = data.links;
      this.tableData = data.data;

      this.loading = false;
    },
  },
  created() {
    this.filters = Object.assign({}, this.filtersInitialState);
    this.fetchFilters();
    this.fetch(window.tracker.lastActivities);
  },
};
</script>

<style>
</style>
