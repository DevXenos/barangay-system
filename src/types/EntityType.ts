export type SqlTimestamp = string & { __sqlTimestampBrand: never };

export type EntityType<T extends string> = {
  id?: `${T}_${string}`;
  created_at?: SqlTimestamp;
  updated_at?: SqlTimestamp;
};
