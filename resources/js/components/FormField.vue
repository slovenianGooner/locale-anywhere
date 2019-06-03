<template>
	<default-field :field="field">
		<template slot="field">
			<div
				class="border-t-4 rounded-b px-4 py-3 mb-2 shadow-md"
				:class="{
					'border-success': field.value.isTranslated,
					'border-danger': !field.value.isTranslated
				}"
				role="alert"
				v-if="resourceId !== undefined"
			>
				<div class="flex">
					<div
						class="py-1"
						:class="{
							'text-success': field.value.isTranslated,
							'text-danger': !field.value.isTranslated
						}"
					>
						<svg
							class="fill-current h-6 w-6 text-teal-500 mr-4"
							xmlns="http://www.w3.org/2000/svg"
							viewBox="0 0 20 20"
						>
							<path
								d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"
							/>
						</svg>
					</div>
					<div>
						<p
							class="font-bold mb-2"
							:class="{
								'text-success': field.value.isTranslated,
								'text-danger': !field.value.isTranslated
							}"
						>
							Status:
							<span v-if="field.value.isTranslated">
								TRANSLATED
							</span>
							<span v-else>NOT TRANSLATED</span>
						</p>
						<p class="text-sm" v-if="field.value.isTranslated">
							Item is translated in
							<strong>{{ currentLocaleName }}</strong
							>. You are updating the translation.
						</p>
						<p class="text-sm" v-else>
							Item is not translated in
							<strong>{{ currentLocaleName }}</strong
							>. You are creating a translation.
						</p>
					</div>
				</div>
			</div>
			<div v-else>
				<input
					class="w-full form-control form-input form-input-bordered"
					:value="currentLocaleName + ' (' + field.locale + ')'"
					disabled="disabled"
				/>
			</div>
		</template>
	</default-field>
</template>
<script>
import { FormField, HandlesValidationErrors } from "laravel-nova";

export default {
	mixins: [FormField, HandlesValidationErrors],

	props: ["resourceName", "resourceId", "field"],

	methods: {
		/*
		 * Set the initial, internal value for the field.
		 */
		setInitialValue() {
			this.value = this.field.locale;
		},

		/**
		 * Fill the given FormData object with the field's internal value.
		 */
		fill(formData) {
			formData.append(this.field.attribute, this.value || "");
		}
	},

	computed: {
		currentLocaleName() {
			let name = null;

			Object.keys(this.field.locales).forEach(locale => {
				if (locale === this.field.locale) {
					name = this.field.locales[locale];
				}
			});

			return name;
		}
	}
};
</script>
