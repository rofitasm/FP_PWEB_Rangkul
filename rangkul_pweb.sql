
/*==============================================================*/
/* Table: AKTIVITAS                                             */
/*==============================================================*/
create table AKTIVITAS 
(
   O_ID              	int 		               not null,
   A_ID                 int 	        NOT NULL AUTO_INCREMENT,
   A_NAMA               varchar(256)                   not null,
   A_LOKASI             varchar(512)                   null,
   A_BATAS_REGIS        timestamp                      null,
   A_DETAIL             long varchar                   null,
   A_ORGANISASI_ASAL    varchar(512)                   null,
   constraint PK_AKTIVITAS primary key clustered (A_ID)
);

/*==============================================================*/
/* Index: MENYELENGGARAKAN_FK                                   */
/*==============================================================*/
create index MENYELENGGARAKAN_FK on AKTIVITAS (
O_ID ASC
);

/*==============================================================*/
/* Table: FOTO_AKTIVITAS                                        */
/*==============================================================*/
create table FOTO_AKTIVITAS 
(
   A_ID                 int 		NOT NULL,
   FA_ID                int 		NOT NULL AUTO_INCREMENT,
   FA_PATH              varchar(256)                   null,
   constraint PK_FOTO_AKTIVITAS primary key clustered (FA_ID)
);

/*==============================================================*/
/* Index: UPLOAD_FK                                             */
/*==============================================================*/
create index UPLOAD_FK on FOTO_AKTIVITAS (
A_ID ASC
);

/*==============================================================*/
/* Table: GABUNG_RELAWAN                                        */
/*==============================================================*/
create table GABUNG_RELAWAN 
(
   GR_ID                int 		NOT NULL AUTO_INCREMENT,
   R_ID                 int 		NOT NULL,
   A_ID                 int 		NOT NULL,
   GR_TGL_DAFTAR        datetime                       not null,
   GR_STATUS            char(16)                       null,
   constraint PK_GABUNG_RELAWAN primary key clustered (GR_ID)
);

/*==============================================================*/
/* Index: GABUNG_RELAWAN_FK                                     */
/*==============================================================*/
create index GABUNG_RELAWAN_FK on GABUNG_RELAWAN (
A_ID ASC
);

/*==============================================================*/
/* Table: LOGIN                                               */
/*==============================================================*/
create table LOGIN
(
   ID_LOGIN             int 		NOT NULL AUTO_INCREMENT,
   EMAIL                varchar(128)                   not null,
   PASSWORD             varchar(128)                   not null,
   ROLE                 char(8)                        not null,
   constraint PK_LOGIN primary key clustered (ID_LOGIN)
);

/*==============================================================*/
/* Table: ORGANISASI                                            */
/*==============================================================*/
create table ORGANISASI 
(
   O_ID                 int 		NOT NULL AUTO_INCREMENT,
   ID_LOGIN             int 		NOT NULL,
   O_NAMA               varchar(256)                   not null,
   O_TGL_BERDIRI        date                           null,
   O_DESKRIPSI          long varchar                   null,
   O_LOKASI             varchar(512)                   null,
   O_TELP               char(30)                       null,
   O_WEB                varchar(256)                   null,
   constraint PK_ORGANISASI primary key clustered (O_ID)
);

/*==============================================================*/
/* Index: LOGIN_ORGANISASI_FK                                   */
/*==============================================================*/
create index LOGIN_ORGANISASI_FK on ORGANISASI (
ID_LOGIN ASC
);

/*==============================================================*/
/* Table: RELAWAN                                               */
/*==============================================================*/
create table RELAWAN 
(
   R_ID                 int 		NOT NULL AUTO_INCREMENT,
   ID_LOGIN             int 		NOT NULL,
   R_NAMA               varchar(256)                   not null,
   R_TELP               varchar(32)                   not null,
   R_TGL_LAHIR          date                           null,
   R_PROFESI            varchar(128)                   null,
   R_PROVINSI_DOM       varchar(128)                   null,
   R_KOTA_DOM           varchar(128)                   null,
   R_FOTO               varchar(256)                   null,
   constraint PK_RELAWAN primary key clustered (R_ID)
);

/*==============================================================*/
/* Index: LOGIN_RELAWAN_FK                                      */
/*==============================================================*/
create index LOGIN_RELAWAN_FK on RELAWAN (
ID_LOGIN ASC
);

alter table AKTIVITAS
   add constraint FK_AKTIVITA_MENYELENG_ORGANISA foreign key (O_ID)
      references ORGANISASI (O_ID)
      on update restrict
      on delete restrict;

alter table FOTO_AKTIVITAS
   add constraint FK_FOTO_AKT_UPLOAD_AKTIVITA foreign key (A_ID)
      references AKTIVITAS (A_ID)
      on update restrict
      on delete restrict;

alter table GABUNG_RELAWAN
   add constraint FK_GABUNG_R_GABUNG_RE_AKTIVITA foreign key (A_ID)
      references AKTIVITAS (A_ID)
      on update restrict
      on delete restrict;

alter table GABUNG_RELAWAN
   add constraint FK_GABUNG_R_GABUNG_RE_RELAWAN foreign key (R_ID)
      references RELAWAN (R_ID)
      on update restrict
      on delete restrict;

alter table ORGANISASI
   add constraint FK_ORGANISA_LOGIN_ORG_LOGIN foreign key (ID_LOGIN)
      references LOGIN (ID_LOGIN)
      on update restrict
      on delete restrict;

alter table RELAWAN
   add constraint FK_RELAWAN_LOGIN_REL_LOGIN foreign key (ID_LOGIN)
      references LOGIN (ID_LOGIN)
      on update restrict
      on delete restrict;
      
alter table LOGIN ADD UNIQUE(EMAIL);
