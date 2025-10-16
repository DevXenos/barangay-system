export type ResultDataType<T = undefined> = {
	status: 200 /* OK: Request successful */
		| 201 /* Created: Resource successfully created */
		| 400 /* Bad Request: Missing or invalid parameters */
		| 401 /* Unauthorized: Invalid or missing credentials */
		| 403 /* Forbidden: Not allowed to access */
		| 404 /* Not Found: Resource doesn’t exist */
		| 409 /* Conflict: Duplicate or business logic conflict */
		| 500 /* Server Error: Unexpected failure */;
	message: string;
	data?: T;
};
