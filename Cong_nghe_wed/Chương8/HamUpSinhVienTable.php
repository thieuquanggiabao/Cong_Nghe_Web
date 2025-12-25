public function up(): void
    {
        Schema::create('sinh_viens', function (Blueprint $table) {
            $table->id();
            $table->string('ten_sinh_vien', 255);
            $table->string('email', 255)->unique();
            $table->timestamps();
        });
    }
