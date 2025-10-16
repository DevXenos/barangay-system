import { EntityType } from "./EntityType";

export type StaffType = {
	first_name: string;
	last_name: string;
	email: string;
	phone_number: string;
	role: string;
	token?: string;
} & EntityType<"staff">;