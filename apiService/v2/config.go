package main

import (
	"context"
	"encoding/json"
	"log"
	"net/http"
	"time"

	"go.mongodb.org/mongo-driver/bson"
	"go.mongodb.org/mongo-driver/mongo/options"
)

type settings struct {
	Name               string
	Connection         string
	FPS                int
	MinCount           int
	Motion             bool
	Blur               int
	Debug              bool
	BufferBefore       int
	BufferAfter        int
	NoMoveRefreshCount int
	Zones              []zone
}
type zone struct {
	X1          int
	Y1          int
	X2          int
	Y2          int
	Threshold   int
	BoxJump     int
	SmallIgnore int
	Area        int
}

func getConfig(w http.ResponseWriter, r *http.Request) {
	// Get our database connection
	conn := databaseClient.Database("doorbell")
	db := conn.Collection("setting")
	filter := bson.M{"_id": 0}
	ctx, cancel := context.WithTimeout(context.Background(), 2*time.Second)
	doc := db.FindOne(ctx, filter)
	cancel()
	var s settings
	doc.Decode(&s)
	json.NewEncoder(w).Encode(s)
	log.Printf("getConfig >> served")
}

func setConfig(w http.ResponseWriter, r *http.Request) {
	decoder := json.NewDecoder(r.Body)
	var s settings
	err := decoder.Decode(&s)
	if err != nil {
		w.WriteHeader(http.StatusInternalServerError)
		log.Printf("Couldn't decode json for setConfig: %s", err)
		return
	}
	conn := databaseClient.Database("doorbell")
	db := conn.Collection("setting")
	ctx, cancel := context.WithTimeout(context.Background(), 2*time.Second)
	filter := bson.M{"_id": 0}
	db.FindOneAndReplace(ctx, filter, s, options.FindOneAndReplace().SetUpsert(true))
	cancel()
	log.Printf("setConfig >> served")
}