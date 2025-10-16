import { EntityType } from "./EntityType";

export type ResidentType = {
	first_name: string;
	middle_name: string;
	last_name: string;
	email: string;
	birth_date: string;
	contact_number: string;
	gender: string;
	civil_status: string;
	address: string;
} & EntityType<'resident'>;