<template>
  <div>
    <ul class="nav" v-if="hasAnyPermission(['users_manage'])">
      <Link
        class="flex items-center group py-3"
        :href="route('dashboard')"
        replace
        :active="route().current('admin.profile.index')"
      >
        <icon
          name="analytic"
          class="w-4 h-4 mr-2"
          :class="
            isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'
          "
        />
        <div
          class="text-sm"
          :class="
            isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'
          "
        >Analytic</div>
      </Link>
    </ul>
    <ul class="nav">
      <li class="nav-item active" v-if="hasAnyPermission(['users_manage'])">
        <a
          data-toggle="collapse"
          aria-expanded="false"
          aria-controls="collapseExample"
          class="flex items-center group py-3"
          href="#landingpage"
        >
          <icon
            name="landingpage"
            class="w-4 h-4 mr-2"
            :class="
              isUrl('admin.tour.index')
                ? 'fill-white'
                : 'fill-indigo-400 group-hover:fill-white'
            "
          />
          <div
            class="text-sm"
            :class="
              isUrl('admin.tour.index')
                ? 'text-white'
                : 'text-indigo-300 group-hover:text-white'
            "
          >Landing Page</div>
          <span class="caret"></span>
        </a>
        <div class="collapse" id="landingpage">
          <ul class="nav nav-collapse">
            <li class="active active-sub" v-if="hasAnyPermission(['users_manage'])">
              <Link
                class="flex items-center group py-3"
                :href="route('landing-page.template.index')"
              >
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                />
                <icon
                  name="template"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('landing-page.template.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <div
                  class="text-sm"
                  :class="
                    isUrl('landing-page.template.index')
                      ? 'text-white'
                      : 'text-indigo-300 group-hover:text-white'
                  "
                >Templates</div>
              </Link>
            </li>
          </ul>
        </div>
      </li>
    </ul>
    <!-- User
    -->
    <ul class="nav">
      <li class="nav-item active" v-if="hasAnyPermission(['create_user'])">
        <a
          data-toggle="collapse"
          aria-expanded="false"
          aria-controls="collapseExample"
          class="flex items-center group py-3"
          href="#user"
        >
          <icon
            name="dropdown"
            class="w-4 h-4 mr-2"
            :class="
              isUrl('admin.tour.index')
                ? 'fill-white'
                : 'fill-indigo-400 group-hover:fill-white'
            "
          />
          <div
            class="text-sm"
            :class="
              isUrl('admin.tour.index')
                ? 'text-white'
                : 'text-indigo-300 group-hover:text-white'
            "
          >{{ __("user_manager") }}</div>
          <span class="caret"></span>
        </a>
        <div class="collapse" id="user">
          <ul class="nav nav-collapse">
            <li class="active active-sub" v-if="hasAnyPermission(['users_manage'])">
              <Link
                class="flex items-center group py-3"
                :href="route('admin.permissions.index')"
                replace
                :active="route().current('admin.permissions.index')"
              >
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('admin.permissions.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <div
                  class="text-sm"
                  :class="
                    isUrl('admin.permissions.index')
                      ? 'text-white'
                      : 'text-indigo-300 group-hover:text-white'
                  "
                >{{ __("permission") }}</div>
              </Link>
            </li>
            <li class="active active-sub" v-if="hasAnyPermission(['users_manage'])">
              <Link class="flex items-center group py-3" :href="route('admin.roles.index')">
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('admin.roles.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <div
                  class="text-sm"
                  :class="
                    isUrl('admin.roles.index')
                      ? 'text-white'
                      : 'text-indigo-300 group-hover:text-white'
                  "
                >{{ __("roles") }}</div>
              </Link>
            </li>
            <li class="active active-sub" v-if="hasAnyPermission(['create_user'])">
              <Link
                class="flex items-center group py-3"
                :href="route('admin.users.index')"
              >
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('admin.users.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <div
                  class="text-sm"
                  :class="
                    isUrl('admin.users.index')
                      ? 'text-white'
                      : 'text-indigo-300 group-hover:text-white'
                  "
                >User</div>
              </Link>
            </li>
            <li class="active active-sub" v-if="hasAnyPermission(['users_manage', 'subadmin'])">
              <Link class="flex items-center group py-3" :href="route('admin.history_acc.index')">
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('admin.history_acc.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <div
                  class="text-sm"
                  :class="
                    isUrl('admin.history_acc.index')
                      ? 'text-white'
                      : 'text-indigo-300 group-hover:text-white'
                  "
                >{{ __("history_account") }}</div>
              </Link>
            </li>
            <li class="active active-sub" v-if="hasAnyPermission(['users_manage', 'subadmin'])">
              <Link class="flex items-center group py-3" :href="route('admin.sales.index')">
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('admin.sales.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <div
                  class="text-sm"
                  :class="
                    isUrl('admin.sales.index')
                      ? 'text-white'
                      : 'text-indigo-300 group-hover:text-white'
                  "
                >{{ __("sales") }}</div>
              </Link>
            </li>

            <li class="active active-sub" v-if="hasAnyPermission(['users_manage'])">
              <Link class="flex items-center group py-3" :href="route('admin.virtual-users.index')">
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('admin.virtual-users.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <div
                  class="text-sm"
                  :class="
                    isUrl('admin.virtual-users.index')
                      ? 'text-white'
                      : 'text-indigo-300 group-hover:text-white'
                  "
                >{{ __("Virtual users") }}</div>
              </Link>
            </li>

            <li class="active active-sub" v-if="hasAnyPermission(['users_manage'])">
              <Link class="flex items-center group py-3" :href="route('owner.index')">
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('owner.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <div
                  class="text-sm"
                  :class="
                    isUrl('owner.index')
                      ? 'text-white'
                      : 'text-indigo-300 group-hover:text-white'
                  "
                >{{ __("Scenes user") }}</div>
              </Link>
            </li>
          </ul>
        </div>
      </li>
    </ul>
    <ul class="nav" v-if="hasAnyPermission(['users_manage'])">
      <Link
        class="flex items-center group py-3"
        :href="route('admin.landingpage.index')"
        :only="['data']"
        preserve-scroll
        :active="route().current('admin.landingpage.index')"
      >
        <icon
          name="language"
          class="w-4 h-4 mr-2"
          :class="
            isUrl('admin.landingpage.index')
              ? 'fill-white'
              : 'fill-indigo-400 group-hover:fill-white'
          "
        />
        <div
          class="text-sm"
          :class="
            isUrl('admin.landingpage.index')
              ? 'text-white'
              : 'text-indigo-300 group-hover:text-white'
          "
        >Language</div>
      </Link>
    </ul>
    <ul class="nav" v-if="hasAnyPermission(['sale_project', 'users_manage'])">
      <Link
        class="flex items-center group py-3"
        :href="route('admin.sales.customer.index')"
        :active="route().current('sales.customer.index')"
      >
        <icon
          name="customer"
          class="w-4 h-4 mr-2"
          :class="
            isUrl('admin.sales.customer.index')
              ? 'fill-white'
              : 'fill-indigo-400 group-hover:fill-white'
          "
        />
        <div
          class="text-sm"
          :class="
            isUrl('admin.sales.customer.index')
              ? 'text-white'
              : 'text-indigo-300 group-hover:text-white'
          "
        >{{ __("customers") }}</div>
      </Link>
    </ul>
    <ul class="nav" v-if="hasAnyPermission(['users_manage'])">
      <Link
        class="flex items-center group py-3"
        :href="route('admin.formSendMail')"
        :active="route().current('admin.formSendMail')"
      >
        <icon
          name="mail"
          class="w-4 h-4 mr-2"
          :class="
            isUrl('admin.formSendMail')
              ? 'fill-white'
              : 'fill-indigo-400 group-hover:fill-white'
          "
        />
        <div
          class="text-sm"
          :class="
            isUrl('admin.formSendMail')
              ? 'text-white'
              : 'text-indigo-300 group-hover:text-white'
          "
        >Mail</div>
      </Link>
    </ul>
    <ul class="nav">
      <Link
        class="flex items-center group py-3"
        v-if="hasAnyPermission(['sale_project'])"
        :href="route('admin.sales.project')"
        :active="route().current('admin.sales.project')"
      >
        <icon
          name="project"
          class="w-4 h-4 mr-2"
          :class="
            isUrl('admin.sales.project')
              ? 'fill-white'
              : 'fill-indigo-400 group-hover:fill-white'
          "
        />
        <div
          class="text-sm"
          :class="
            isUrl('admin.sales.project')
              ? 'text-white'
              : 'text-indigo-300 group-hover:text-white'
          "
        >{{ __("my_project") }}</div>
      </Link>
    </ul>
    <!-- VR -->
    <ul class="nav" v-if="hasAnyPermission(['users_manage'])">
      <Link
        class="flex items-center group py-3"
        :href="route('admin.userVR')"
        :active="route().current('admin.userVR')"
      >
        <icon
          name="vr"
          class="w-4 h-4 mr-2"
          :class="
            isUrl('admin.userVR')
              ? 'fill-white'
              : 'fill-indigo-400 group-hover:fill-white'
          "
        />
        <div
          class="text-sm"
          :class="
            isUrl('admin.userVR')
              ? 'text-white'
              : 'text-indigo-300 group-hover:text-white'
          "
        >VR</div>
      </Link>
    </ul>
    <!-- Tour -->
    <ul class="nav">
      <li class="nav-item active" v-if="hasAnyPermission(['tour_technical'])">
        <a data-toggle="collapse" class="flex items-center group py-3" href="#tour">
          <icon
            name="dropdown"
            class="w-4 h-4 mr-2"
            :class="
              isUrl('admin.tour.index')
                ? 'fill-white'
                : 'fill-indigo-400 group-hover:fill-white'
            "
          />
          <div
            class="text-sm"
            :class="
              isUrl('admin.tour.index')
                ? 'text-white'
                : 'text-indigo-300 group-hover:text-white'
            "
          >{{ __("Tour360") }}</div>
          <span class="caret"></span>
        </a>
        <div class="collapse" id="tour">
          <ul class="nav nav-collapse">
            <li class="active active-sub" v-if="hasAnyPermission(['tour_technical'])">
              <Link class="flex items-center group py-3" :href="route('admin.tour.index')">
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('admin.tour.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <icon
                  name="tour"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('admin.tour.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <div
                  class="text-sm"
                  :class="
                    isUrl('admin.tour.index')
                      ? 'text-white'
                      : 'text-indigo-300 group-hover:text-white'
                  "
                >Tour</div>
              </Link>
            </li>
            <li class="active active-sub" v-if="hasAnyPermission(['users_manage'])">
              <Link class="flex items-center group py-3" :href="route('admin.tour.category.index')">
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('admin.tour.category.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <icon
                  name="cateory"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('admin.tour.category.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <div
                  class="text-sm"
                  :class="
                    isUrl('admin.tour.category.index')
                      ? 'text-white'
                      : 'text-indigo-300 group-hover:text-white'
                  "
                >Category Hostpot</div>
              </Link>
            </li>
            <li class="active active-sub" v-if="hasAnyPermission(['users_manage'])">
              <Link
                class="flex items-center group py-3"
                :href="route('admin.tour.tour_category.index')"
              >
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('admin.tour.tour_category.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <icon
                  name="cateory"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('admin.tour.tour_category.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <div
                  class="text-sm"
                  :class="
                    isUrl('admin.tour.tour_category.index')
                      ? 'text-white'
                      : 'text-indigo-300 group-hover:text-white'
                  "
                >Category Tour</div>
              </Link>
            </li>
            <li class="active active-sub" v-if="hasAnyPermission(['users_manage'])">
              <Link
                class="flex items-center group py-3"
                :href="route('admin.tour.scene_category.index')"
              >
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('admin.tour.scene_category.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <icon
                  name="cateory"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('admin.tour.scene_category.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <div
                  class="text-sm"
                  :class="
                    isUrl('admin.tour.scene_category.index')
                      ? 'text-white'
                      : 'text-indigo-300 group-hover:text-white'
                  "
                >Category TourScenes</div>
              </Link>
            </li>
          </ul>
        </div>
      </li>
    </ul>
    <!-- end -->
    <ul class="nav" v-if="hasAnyPermission(['create_project', 'subadmin'])">
      <Link class="flex items-center group py-3" :href="route('admin.project.index', 1)">
        <icon
          name="tour"
          class="w-4 h-4 mr-2"
          :class="
            isUrl('admin.field.index')
              ? 'fill-white'
              : 'fill-indigo-400 group-hover:fill-white'
          "
        />
        <div
          class="text-sm"
          :class="
            isUrl('admin.field.index')
              ? 'text-white'
              : 'text-indigo-300 group-hover:text-white'
          "
        >{{ __("field") }}</div>
      </Link>
    </ul>
    <ul class="nav" v-if="hasAnyPermission(['users_manage'])">
      <Link class="flex items-center group py-3" :href="route('mode_map.index')">
        <icon
          name="tour"
          class="w-4 h-4 mr-2"
          :class="
            isUrl('mode_map.index')
              ? 'fill-white'
              : 'fill-indigo-400 group-hover:fill-white'
          "
        />
        <div
          class="text-sm"
          :class="
            isUrl('mode_map.index')
              ? 'text-white'
              : 'text-indigo-300 group-hover:text-white'
          "
        >{{ __("Mode Map") }}</div>
      </Link>
    </ul>
    <ul class="nav" v-if="hasAnyPermission(['3dscan'])">
      <li class="nav-item active">
        <a data-toggle="collapse" class="flex items-center group py-3" href="#scan">
          <icon
            name="dropdown"
            class="w-4 h-4 mr-2"
            :class="
              isUrl('admin.tour.index')
                ? 'fill-white'
                : 'fill-indigo-400 group-hover:fill-white'
            "
          />
          <div
            class="text-sm"
            :class="
              isUrl('admin.tour.index')
                ? 'text-white'
                : 'text-indigo-300 group-hover:text-white'
            "
          >Scan Manager</div>
          <span class="caret"></span>
        </a>
        <div class="collapse" id="scan">
          <ul class="nav nav-collapse">
            <li class="active active-sub" v-if="hasAnyPermission(['3dscan'])">
              <Link class="flex items-center group py-3" :href="route('admin.scan.index')">
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('admin.scan.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <div
                  class="text-sm"
                  :class="
                    isUrl('admin.scan.index')
                      ? 'text-white'
                      : 'text-indigo-300 group-hover:text-white'
                  "
                >Scan List</div>
              </Link>
            </li>

            <li class="active active-sub" v-if="hasAnyPermission(['users_manage'])">
              <Link class="flex items-center group py-3" :href="route('admin.category_scan.index')">
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('admin.category_scan.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <div
                  class="text-sm"
                  :class="
                    isUrl('admin.category_scan.index')
                      ? 'text-white'
                      : 'text-indigo-300 group-hover:text-white'
                  "
                >Scan Cateogry</div>
              </Link>
            </li>
          </ul>
        </div>
      </li>
    </ul>
    <ul
      class="nav"
      v-if="
        hasAnyPermission([
          'manager_event',
          'manager_booth',
          'create_virtual',
        ])
      "
    >
      <Link class="flex items-center group py-3" :href="route('virtual-expo.index')" replace>
        <icon
          name="virtual"
          class="w-4 h-4 mr-2"
          :class="
            isUrl('virtual-expo.index')
              ? 'fill-white'
              : 'fill-indigo-400 group-hover:fill-white'
          "
        />
        <div
          class="text-sm"
          :class="
            isUrl('virtual-expo.index')
              ? 'text-white'
              : 'text-indigo-300 group-hover:text-white'
          "
        >{{ __('virtual_expo') }}</div>
      </Link>
    </ul>
    <!-- Virtual Expo -->
    <ul class="nav">
      <li
        class="nav-item active"
        v-if="
          hasAnyPermission([
            'users_manage',
            'create_booth',
            'create_virtual'
        
          ])
        "
      >
        <a data-toggle="collapse" class="flex items-center group py-3" href="#virtual">
          <icon
            name="dropdown"
            class="w-4 h-4 mr-2"
            :class="
              isUrl('admin.tour.index')
                ? 'fill-white'
                : 'fill-indigo-400 group-hover:fill-white'
            "
          />
          <div
            class="text-sm"
            :class="
              isUrl('admin.tour.index')
                ? 'text-white'
                : 'text-indigo-300 group-hover:text-white'
            "
          >Virtual Expo</div>
          <span class="caret"></span>
        </a>
        <div class="collapse" id="virtual">
          <ul class="nav nav-collapse">
            <li
              class="active active-sub"
              v-if="
                hasAnyPermission([
                  'users_manage',
                  'manager_event',
                  'manager_booth',
                  'create_virtual',
                ])
              "
            >
              <Link
                class="flex items-center group py-3"
                :href="route('virtual-expo.index')"
                replace
              >
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('virtual-expo.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <icon
                  name="virtual"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('virtual-expo.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <div
                  class="text-sm"
                  :class="
                    isUrl('virtual-expo.index')
                      ? 'text-white'
                      : 'text-indigo-300 group-hover:text-white'
                  "
                >Virtual</div>
              </Link>
            </li>
            <li
              class="active active-sub"
              v-if="hasAnyPermission(['users_manage', 'create_virtual'])"
            >
              <Link
                class="flex items-center group py-3"
                :href="route('virtual-expo.samples.booth')"
              >
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('virtual-expo.samples.booth')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <icon
                  name="sample"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('virtual-expo.samples.booth')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <div
                  class="text-sm"
                  :class="
                    isUrl('virtual-expo.samples.booth')
                      ? 'text-white'
                      : 'text-indigo-300 group-hover:text-white'
                  "
                >Sample Booth</div>
              </Link>
            </li>
            <li
              class="active active-sub"
              v-if="hasAnyPermission(['users_manage', 'create_virtual', 'create_booth'])"
            >
              <Link class="flex items-center group py-3" :href="route('booth.list')">
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('vbooth.list')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <icon
                  name="sample"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('booth.list')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <div
                  class="text-sm"
                  :class="
                    isUrl('booth.list')
                      ? 'text-white'
                      : 'text-indigo-300 group-hover:text-white'
                  "
                >{{ __('booth') }}</div>
              </Link>
            </li>
            <li
              class="active active-sub"
              v-if="hasAnyPermission(['users_manage', 'create_virtual'])"
            >
              <Link
                class="flex items-center group py-3"
                :href="route('virtual-expo.samples.index')"
              >
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('virtual-expo.samples.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <icon
                  name="sample"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('virtual-expo.samples.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <div
                  class="text-sm"
                  :class="
                    isUrl('virtual-expo.samples.index')
                      ? 'text-white'
                      : 'text-indigo-300 group-hover:text-white'
                  "
                >Sample</div>
              </Link>
            </li>
            <li class="active active-sub" v-if="hasAnyPermission(['users_manage'])">
              <Link
                class="flex items-center group py-3"
                :href="route('virtual-expo.category-sample.index')"
              >
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('virtual-expo.category-sample.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <icon
                  name="cateory"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('virtual-expo.category-sample.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <div
                  class="text-sm"
                  :class="
                    isUrl('virtual-expo.category-sample.index')
                      ? 'text-white'
                      : 'text-indigo-300 group-hover:text-white'
                  "
                >Category Sample</div>
              </Link>
            </li>
            <li class="active active-sub" v-if="hasAnyPermission(['users_manage'])">
              <Link
                class="flex items-center group py-3"
                :href="route('virtual-expo.category.index')"
              >
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('virtual-expo.category.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <icon
                  name="cateory"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('virtual-expo.category.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <div
                  class="text-sm"
                  :class="
                    isUrl('virtual-expo.category.index')
                      ? 'text-white'
                      : 'text-indigo-300 group-hover:text-white'
                  "
                >Category Booth</div>
              </Link>
            </li>
            <li class="active active-sub" v-if="hasAnyPermission(['users_manage'])">
              <Link class="flex items-center group py-3" :href="route('virtual-expo.field.index')">
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('virtual-expo.field.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <icon
                  name="cateory"
                  class="w-4 h-4 mr-2"
                  :class="
                    isUrl('virtual-expo.field.index')
                      ? 'fill-white'
                      : 'fill-indigo-400 group-hover:fill-white'
                  "
                />
                <div
                  class="text-sm"
                  :class="
                    isUrl('virtual-expo.field.index')
                      ? 'text-white'
                      : 'text-indigo-300 group-hover:text-white'
                  "
                >Field Booth</div>
              </Link>
            </li>

            <li
              class="active active-sub"
              v-if="hasAnyPermission(['users_manage', 'manager_booth', 'manager_event', 'create_booth'])"
            >
              <Link class="flex items-center group py-3" :href="route('trade.index')">
                <icon
                  name="scan"
                  class="w-4 h-4 mr-2"
                  :class="isUrl('trade.index') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'"
                />
                <icon
                  name="customer"
                  class="w-4 h-4 mr-2"
                  :class="isUrl('trade.index') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'"
                />
                <div
                  class="text-sm"
                  :class="isUrl('trade.index') ? 'text-white' : 'text-indigo-300 group-hover:text-white'"
                >Contact</div>
              </Link>
            </li>
          </ul>
        </div>
      </li>
    </ul>
    <!-- end Virtual -->
    <ul class="nav">
      <Link
        class="flex items-center group py-3"
        :href="route('logout')"
        as="button"
        type="button"
        method="post"
      >
        <icon
          name="logout"
          class="w-4 h-4 mr-2"
          :class="isUrl('logout') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'"
        />
        <div
          class="text-sm"
          :class="
            isUrl('logout')
              ? 'text-white'
              : 'text-indigo-300 group-hover:text-white'
          "
        >{{ __("logout") }}</div>
      </Link>
    </ul>
  </div>
</template>

<script>
import Icon from "@/Components/Icon";
import { Link } from "@inertiajs/inertia-vue";
export default {
  components: {
    Icon,
    Link
  },
  props: {
    url: String
  },
  methods: {
    isUrl(...urls) {
      if (urls[0] === "") {
        return this.url === "";
      }
      return urls.filter(url => this.url.startsWith(url)).length;
    }
  }
};
</script>
