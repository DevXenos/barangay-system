import { EntityType } from "./EntityType";
export type Announcement = {
	title: string;
	description: string;
	date: string;
	time: string;
} & Omit<EntityType<"announcement">, 'updated_at'>;